<?php

use Illuminate\Support\Str;

if (!function_exists('processVideoLink')) {
    function processVideoLink(?string $src): string
    {
        $str = Str::of($src);

        if ($str->contains('vkvideo')) {
            $after = $str->after('/video');

            if ($after) {
                [$oid, $id] = array_pad(explode('_', $after), 2, null);

                if ($oid && $id) return "https://vkvideo.ru/video_ext.php?oid={$oid}&id={$id}";
            }
        } elseif ($str->contains('youtube')) {
            $videoId = $str->after('v=')->before('&');

            if ($videoId) return "https://www.youtube.com/embed/{$videoId}";
        } elseif ($str->contains('rutube')) {
            $videoId = $str->after('video/')->before('/');

            if ($videoId) return "https://rutube.ru/play/embed/{$videoId}";
        }

        return $src;
    }
}
