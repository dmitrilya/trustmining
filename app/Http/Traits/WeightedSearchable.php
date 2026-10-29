<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait WeightedSearchable
{
    public function scopeWithRelevance(Builder $query, string $searchTerm): Builder
    {
        $weights = static::$searchWeights ?? [];

        if (empty($weights)) return $query;

        $rawSql = [];
        $bindings = [];
        $likeTerm = '%' . $searchTerm . '%';

        $relationsToWith = collect(array_keys($weights))
            ->filter(fn($field) => str_contains($field, '.'))
            ->map(fn($field) => implode('.', array_slice(explode('.', $field), 0, -1)))
            ->unique()
            ->toArray();

        if (!empty($relationsToWith)) $query->with($relationsToWith);

        foreach ($weights as $field => $weight) {
            if (str_contains($field, '.')) {
                $sqlPart = $this->buildNestedExistsSql($field, $likeTerm);
                if ($sqlPart) {
                    $rawSql[] = "(CASE WHEN {$sqlPart} THEN {$weight} ELSE 0 END)";
                    $bindings[] = $likeTerm;
                }
            } else {
                $table = $this->getTable();
                $fieldSettings = static::$searchSettings[$field] ?? null;

                if ($fieldSettings) {
                    $expression = "`{$table}`.`{$field}`";

                    if (!empty($fieldSettings['strip_tags'])) $expression = "REGEXP_REPLACE({$expression}, '<[^>]*>', '')";

                    if (!empty($fieldSettings['limit'])) {
                        $limit = (int) $fieldSettings['limit'];
                        $expression = "SUBSTRING({$expression}, 1, {$limit})";
                    }

                    $rawSql[] = "(CASE WHEN {$expression} LIKE ? THEN {$weight} ELSE 0 END)";
                } else {
                    $rawSql[] = "(CASE WHEN `{$table}`.`{$field}` LIKE ? THEN {$weight} ELSE 0 END)";
                }

                $bindings[] = $likeTerm;
            }
        }

        return $query->select($this->getTable() . '.*')
            ->addSelect(DB::raw(implode(' + ', $rawSql) . ' AS relevance'))
            ->addBinding($bindings, 'select')
            ->having('relevance', '>', 0)
            ->orderByDesc('relevance');
    }

    private function buildNestedExistsSql(string $fieldPath, string $likeTerm, $currentModel = null): string
    {
        $currentModel = $currentModel ?? $this;
        $segments = explode('.', $fieldPath);
        $relationName = array_shift($segments);

        if (!method_exists($currentModel, $relationName)) return '';

        $relation = $currentModel->{$relationName}();
        $relatedModel = $relation->getRelated();
        $relatedTable = $relatedModel->getTable();

        if ($relation instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
            $pivotTable = $relation->getTable();
            $foreignPivotKey = $relation->getQualifiedForeignPivotKeyName();
            $relatedPivotKey = $relation->getQualifiedRelatedPivotKeyName();

            $parentKey = $currentModel->getQualifiedKeyName();
            $relatedKey = $relatedModel->getQualifiedKeyName();

            if (count($segments) === 1) {
                $targetField = $segments[0];
                return "EXISTS (
                    SELECT 1 FROM `{$pivotTable}`
                    JOIN `{$relatedTable}` ON `{$relatedTable}`.`id` = {$relatedPivotKey}
                    WHERE {$foreignPivotKey} = {$parentKey} 
                      AND `{$relatedTable}`.`{$targetField}` LIKE ?
                )";
            }

            $nestedSql = $this->buildNestedExistsSql(implode('.', $segments), $likeTerm, $relatedModel);
            return "EXISTS (
                SELECT 1 FROM `{$pivotTable}`
                JOIN `{$relatedTable}` ON `{$relatedTable}`.`id` = {$relatedPivotKey}
                WHERE {$foreignPivotKey} = {$parentKey} 
                  AND {$nestedSql}
            )";
        }

        if ($relation instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
            $foreignKey = $relation->getQualifiedForeignKeyName();
            $ownerKey = $relation->getQualifiedOwnerKeyName();
        } else {
            $foreignKey = $relation->getExistenceCompareKey();
            $ownerKey = $relation->getQualifiedParentKeyName();
        }

        if (count($segments) === 1) {
            $targetField = $segments[0];
            return "EXISTS (SELECT 1 FROM `{$relatedTable}` WHERE {$ownerKey} = {$foreignKey} AND `{$relatedTable}`.`{$targetField}` LIKE ?)";
        }

        $nestedSql = $this->buildNestedExistsSql(implode('.', $segments), $likeTerm, $relatedModel);
        return "EXISTS (SELECT 1 FROM `{$relatedTable}` WHERE {$ownerKey} = {$foreignKey} AND {$nestedSql})";
    }

    public function scopeWithViewsPriority(Builder $query, string $period): Builder
    {
        return $query->withCount(['views' => function ($q) use ($period) {
            $q->where('created_at', '>=', now()->parse($period));
        }])->orderByDesc('views_count');
    }
}
