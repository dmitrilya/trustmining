<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Blog\Guide;

trait GuideTrait
{
    public function getGuides($request = null)
    {
        $guides = Guide::where('moderation', false)->with(['likes', 'user:id,name'])
            ->select(['id', 'user_id', 'title', 'subtitle', 'preview', 'created_at']);

        if (isset($request)) {
            if ($request->tags && count($request->tags)) $guides = $guides->where(function ($q) use ($request) {
                $q->whereJsonContains('tags', $request->tags[0]);

                for ($i = 1; $i < count($request->tags); $i++) {
                    $q->orWhereJsonContains('tags', $request->tags[$i]);
                }
            });

            if ($request->sort) {
                switch ($request->sort) {
                    case 'newest':
                        $guides = $guides->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $guides = $guides->orderBy('created_at');
                        break;
                    case 'more_likes':
                        $guides = $guides->withCount('likes')->orderBy('likes_count', 'desc');
                        break;
                    case 'less_likes':
                        $guides = $guides->withCount('likes')->orderBy('likes_count');
                        break;
                    case 'more_views':
                        $guides = $guides->withCount('views')->orderBy('views_count', 'desc');
                        break;
                    case 'less_views':
                        $guides = $guides->withCount('views')->orderBy('views_count');
                        break;
                }
            } else $guides = $guides->orderBy('created_at', 'desc');
        } else $guides = $guides->orderBy('created_at', 'desc');

        return $guides;
    }
}
