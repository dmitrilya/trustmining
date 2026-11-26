<?php

return [
    'settings' => [
        'custom_definition' => [
            'id'  => 'trustmining-html5-definitions',
            'rev' => 1,
            'debug' => false,
            'attributes' => [
                ['li', 'data-list', 'Enum#bullet,ordered'],
                ['span', 'contenteditable', 'Enum#false'],
                ['span', 'data-term', 'Text'],
                ['span', 'data-coin', 'Text'],
                ['span', 'style', \App\Services\Purifier\CoinUrlValidator::class],
            ],
        ],
        'forum_default' => [
            'HTML.Allowed' => 'b,strong,i,div,a[href|title],br,img[src|alt],iframe[src|frameborder]',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|rutube\.ru/play/embed/|vkvideo\.ru/video_ext\.php)%',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'HTML.MaxImgLength' => null, // Ограничение размера картинки (по желанию)
            'CSS.AllowedProperties' => [], // Запрещаем инлайновые стили (style="") для безопасности
            'AutoFormat.RemoveEmpty' => true,
        ],
        'insight_article' => [
            'HTML.Allowed' => 'div[class],b,strong,i,em,u,a[href|title|class|target],ul,ol,li[data-list],p[class],br,span[contenteditable|class|data-term|data-coin|style],img[width|height|alt|src|class],blockquote,pre,h2,h3,iframe[src|class|frameborder],table,thead,tbody,tr,th,td',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|rutube\.ru/play/embed/|vkvideo\.ru/video_ext\.php)%',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedClasses' => [
                'inline',
                'ql-ui',
                'quill-embed-image',
                'quill-embed-video',
                'ql-align-center',
                'ql-align-right',
                'ql-align-justify',
                'ql-color-main-text-color',
                'ql-color-secondary-text-color',
                'ql-bg-green-bg-color',
                'ql-bg-indigo-bg-color',
                'ql-code-block-container',
                'ql-code-block',
                'term',
                'rate'
            ],
            'HTML.DefinitionID' => 'insight_article',
            'HTML.DefinitionRev' => 1,
            'CSS.AllowedProperties' => ['--coin-url'],
            'AutoFormat.RemoveEmpty' => false,
        ],
        'insight_post' => [
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title|class|target],p[class],br,span[class|data-term|data-coin|style]',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedClasses' => ['inline', 'term', 'rate'],
            'HTML.DefinitionID'    => 'insight_post',
            'HTML.DefinitionRev'   => 1,
            'CSS.AllowedProperties' => ['--coin-url'],
            'AutoFormat.RemoveEmpty' => true,
        ],
        'description' => [
            'HTML.Allowed' => 'div,b,strong,ul,ol,li[data-list],span[contenteditable|class],p[class],br',
            'Attr.AllowedClasses' => ['inline', 'ql-ui'],
            'HTML.DefinitionID'    => 'description',
            'HTML.DefinitionRev'   => 1,
            'CSS.AllowedProperties' => [],
            'AutoFormat.RemoveEmpty' => false,
        ],
    ],
];
