<?php

use Illuminate\Support\Str;

if (!function_exists('processVideoLink')) {
    function processVideoLink(?string $src): string
    {
        if (!$src) return '';

        $url = parse_url($src);
        $host = $url['host'] ?? '';
        $path = $url['path'] ?? '';
        $str = Str::of($src);

        if (str_contains($host, 'vkvideo.ru') || str_contains($host, 'vk.com')) {
            $videoPart = $str->afterLast('/video')->before('?')->trim('/');
            if ($videoPart->contains('_')) {
                [$oid, $id] = explode('_', $videoPart);
                return "https://vkvideo.ru/video_ext.php?oid={$oid}&id={$id}";
            }
        } elseif (str_contains($host, 'youtube.com') || $host === 'youtu.be') {
            $videoId = '';

            if ($host === 'youtu.be') $videoId = trim($path, '/');
            elseif (str_contains($path, '/shorts/')) $videoId = $str->after('/shorts/')->before('?');
            else {
                parse_str($url['query'] ?? '', $query);
                $videoId = $query['v'] ?? '';
            }

            if ($videoId) return "https://www.youtube.com/embed/{$videoId}";
        } elseif (str_contains($host, 'rutube.ru')) {
            $videoId = $str->after('/video/')->before('/')->before('?');

            if ($videoId) return "https://rutube.ru/play/embed/{$videoId}";
        }

        return $src;
    }
}
