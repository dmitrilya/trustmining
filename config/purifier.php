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
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title|class|target],ul,ol,li[data-list],p[class],br,span[contenteditable|class],img[width|height|alt|src|class],blockquote,pre,h2,h3,iframe[src|class|frameborder],table,thead,tbody,tr,th,td',
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
                'ql-bg-indigo-bg-color'
            ],
            'HTML.DefinitionID' => 'insight_article',
            'HTML.DefinitionRev' => 1,
            'CSS.AllowedProperties' => [],
            'AutoFormat.RemoveEmpty' => false,
        ],
        'insight_post' => [
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title|class|target],p[class],br,span[class]',
            'URI.AllowedSchemes' => ['http' => true, 'https' => true, 'mailto' => true],
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedClasses' => ['inline'],
            'HTML.DefinitionID'    => 'quill-editor-post',
            'HTML.DefinitionRev'   => 1,
            'CSS.AllowedProperties' => [],
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
