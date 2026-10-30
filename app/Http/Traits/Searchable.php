<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait Searchable
{
    protected static string $searchableSeparator = '|||';

    public static function search(string $query, int $limit = 20, ?callable $constraints = null, ?string $viewsSince = null): Collection
    {
        $query = trim($query);

        if ($query === '' || $limit < 1) return new Collection();

        $weights = static::$searchWeights ?? [];
        if (empty($weights)) return new Collection();

        $type = (new static())->getMorphClass();

        $escapedQuery = strtr($query, ['!' => '!!', '%' => '!%', '_' => '!_']);

        $documents = DB::table('searchables')
            ->where('searchable_type', $type)
            ->whereRaw("content LIKE ? ESCAPE '!'", ['%' . $escapedQuery . '%'])
            ->get(['searchable_id', 'content']);

        if ($documents->isEmpty()) return new Collection();

        $scores = [];

        foreach ($documents as $document) {
            $fields = explode(static::$searchableSeparator, $document->content);
            $relevance = 0;

            foreach (array_values($weights) as $index => $weight) {
                if (!isset($fields[$index])) continue;

                $matched = mb_stripos($fields[$index], $query, 0, 'UTF-8');

                if ($matched !== false) $relevance += $weight;
            }

            if ($relevance > 0) $scores[$document->searchable_id] = $relevance;
        }

        if (empty($scores)) return new Collection();

        $builder = static::query()->whereKey(array_keys($scores));

        if ($constraints) $constraints($builder);

        $keyName = (new static())->getKeyName();

        $ids = $builder->pluck($keyName)->all();

        if (empty($ids)) return new Collection();

        $views = [];

        if ($viewsSince !== null) {
            $since = now()->modify($viewsSince);

            $views = DB::table('views')
                ->select('viewable_id')
                ->selectRaw('COUNT(*) AS views_count')
                ->where('viewable_type', $type)
                ->whereIn('viewable_id', $ids)
                ->where('created_at', '>=', $since)
                ->groupBy('viewable_id')
                ->pluck('views_count', 'viewable_id')
                ->all();
        }

        usort($ids, function ($a, $b) use ($scores, $views) {
            $relevanceComparison = ($scores[$b] ?? 0) <=> ($scores[$a] ?? 0);

            if ($relevanceComparison !== 0) {
                return $relevanceComparison;
            }

            return ($views[$b] ?? 0) <=> ($views[$a] ?? 0);
        });

        $ids = array_slice($ids, 0, $limit);

        $models = static::query()->whereKey($ids)->get()->keyBy($keyName);

        return new Collection(
            collect($ids)
                ->map(function ($id) use ($models, $scores, $views) {
                    $item = $models->get($id);

                    if (!$item) return null;

                    $item->setAttribute('relevance', $scores[$id] ?? 0);
                    $item->setAttribute('views_count', $views[$id] ?? 0);

                    return $item;
                })
                ->filter()
                ->values()
                ->all()
        );
    }

    public function syncSearchable(bool $forceDependents = false): void
    {
        $this->syncSearchableRecord();

        $this->syncSearchableDependents($forceDependents);
    }

    public function syncSearchableRecord(): void
    {
        if (empty(static::$searchWeights)) return;

        $values = [];

        foreach (array_keys(static::$searchWeights) as $path) {
            $value = $this->resolveSearchableValue($path);

            $settings = static::$searchSettings[$path] ?? [];

            if (!empty($settings['strip_tags'])) $value = strip_tags($value);
            if (!empty($settings['limit'])) $value = mb_substr($value, 0, $settings['limit']);

            $values[] = trim($value);
        }

        $content = implode(static::$searchableSeparator, $values);

        DB::table('searchables')->updateOrInsert(
            [
                'searchable_type' => $this->getMorphClass(),
                'searchable_id' => $this->getKey(),
            ],
            [
                'content' => $content,
            ]
        );
    }

    protected function resolveSearchableValue(string $path): string
    {
        $segments = explode('.', $path);

        $model = $this;

        foreach ($segments as $index => $segment) {
            if ($index === count($segments) - 1) return (string) ($model->{$segment} ?? '');

            if (!method_exists($model, $segment)) return '';

            $relation = $model->{$segment}();
            if (!$relation instanceof Relation) return '';

            $model = $relation->first();
            if (!$model instanceof Model) return '';
        }

        return '';
    }

    public function syncSearchableDependents(bool $force = false): void
    {
        $dependents = static::$searchableDependents ?? [];
        if (empty($dependents)) return;

        $relations = [];

        foreach ($dependents as $field => $models) {
            if (!$force && !$this->wasChanged($field)) continue;

            foreach ($models as $modelClass => $relationPath)
                $relations[$modelClass][$relationPath] = true;
        }

        $processed = [];

        foreach ($relations as $modelClass => $paths)
            foreach (array_keys($paths) as $path)
                $this->syncDependentPath($path, $modelClass, $processed);
    }

    protected function syncDependentPath(string $path, string $modelClass, array &$processed): void
    {
        $segments = explode('.', $path);

        $this->walkDependentRelations($this, $segments, $modelClass, $processed);
    }

    protected function walkDependentRelations(Model $model, array $segments, string $modelClass, array &$processed): void
    {
        if (empty($segments)) return;

        $segment = array_shift($segments);
        if (!method_exists($model, $segment)) {
            throw new \RuntimeException(
                "Relation {$segment} not found in " . get_class($model)
            );
        }

        $relation = $model->{$segment}();
        if (!$relation instanceof Relation) {
            throw new \RuntimeException(
                "{$segment} is not an Eloquent relation in " . get_class($model)
            );
        }

        $related = $relation->getRelated();

        if (empty($segments)) {
            if (!$related instanceof $modelClass) {
                throw new \RuntimeException(
                    "Relation does not return {$modelClass}"
                );
            }

            $column = $related->qualifyColumn($related->getKeyName());

            $relation->chunkById(200, function (Collection $models) use (&$processed, $modelClass) {
                foreach ($models as $dependent) {
                    if (!$dependent instanceof $modelClass) continue;

                    $key = get_class($dependent) . ':' . $dependent->getKey();
                    if (isset($processed[$key])) continue;

                    $processed[$key] = true;

                    $dependent->syncSearchableRecord();
                }
            }, $column);

            return;
        }

        $relation->chunkById(200, function (Collection $models) use ($segments, $modelClass, &$processed) {
            foreach ($models as $relatedModel)
                $this->walkDependentRelations($relatedModel, $segments, $modelClass, $processed);
        }, $related->qualifyColumn($related->getKeyName()));
    }

    public function deleteSearchable(): void
    {
        DB::table('searchables')
            ->where('searchable_type', $this->getMorphClass())
            ->where('searchable_id', $this->getKey())
            ->delete();
    }

    public static function rebuildSearchables(): void
    {
        static::query()->chunkById(200, function ($models) {
            foreach ($models as $model)
                $model->syncSearchableRecord();
        });
    }
}
