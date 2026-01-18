<?php

return [
    'settings' => [
        'forum_default' => [
            // 1. Разрешенные теги
            'HTML.Allowed' => 'b,strong,i,div,a[href|title],br,img[src|alt],iframe[src|frameborder]',

            // 2. Правила для ссылок и картинок
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],

            // 3. Фильтр для iframe (Safe Iframe)
            'HTML.SafeIframe' => true,
            // Разрешаем только конкретные домены для iframe
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|rutube\.ru/play/embed/|vkvideo\.ru/video_ext\.php)%',

            // 4. Дополнительные настройки безопасности
            'Attr.AllowedFrameTargets' => ['_blank'],
            'HTML.MaxImgLength' => null, // Ограничение размера картинки (по желанию)
            'CSS.AllowedProperties' => [], // Запрещаем инлайновые стили (style="") для безопасности
            'AutoFormat.RemoveEmpty' => true,
        ],
    ],
];
