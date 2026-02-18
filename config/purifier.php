<?php

return [
    'settings' => [
        'forum_default' => [
            'HTML.Allowed' => 'b,strong,i,div,a[href|title],br,img[src|alt],iframe[src|frameborder]',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|rutube\.ru/play/embed/|vkvideo\.ru/video_ext\.php)%',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'HTML.MaxImgLength' => null, // Ограничение размера картинки (по желанию)
            'CSS.AllowedProperties' => [], // Запрещаем инлайновые стили (style="") для безопасности
            'AutoFormat.RemoveEmpty' => true,
            'Cache.SerializerPath' => storage_path('app/purifier'),
        ],
        'insight_article' => [
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,p[class],br,span[class],img[width|height|alt|src|class],blockquote,pre,h2,h3,iframe[src|class|frameborder],table,thead,tbody,tr,th,td',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|rutube\.ru/play/embed/|vkvideo\.ru/video_ext\.php)%',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedClasses' => [
                'quill-embed-image',
                'quill-embed-video',
                'ql-align-center',
                'ql-align-right',
                'ql-align-justify',
                'main-text-color',
                'secondary-text-color',
                'green-bg-color',
                'indigo-bg-color'
            ],
            'HTML.DefinitionID'    => 'quill-editor',
            'HTML.DefinitionRev'   => 1,
            'CSS.AllowedProperties' => [],
            'AutoFormat.RemoveEmpty' => true,
            'Cache.SerializerPath' => storage_path('app/purifier'),
        ],
        'insight_post' => [
            'HTML.Allowed' => 'div,b,strong,a[href|title],p[class],br,span[class],pre,h2',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'Attr.AllowedFrameTargets' => ['_blank'],
            'HTML.DefinitionID'    => 'quill-editor',
            'HTML.DefinitionRev'   => 1,
            'CSS.AllowedProperties' => [],
            'AutoFormat.RemoveEmpty' => true,
            'Cache.SerializerPath' => storage_path('app/purifier'),
        ]
    ],
];
