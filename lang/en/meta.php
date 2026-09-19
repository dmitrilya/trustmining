<?php

return [
    'rating' => [
        'title' => 'Mining ratings :year: hostings, ASICs, and companies',
        'description' => 'Independent ratings for the mining industry. Find the best hardware suppliers, hosting hotels, and profitable ASIC miners on Trust Mining',
        'header' => 'Mining industry ratings',
        'breadcrumb' => 'Ratings',

        'asics' => [
            'title' => 'Top ASICs: the best miners in :year',
            'description' => 'Current ASIC ratings. Compare equipment by daily profitability or return on investment speed on the Trust Mining website',
            'header' => 'ASIC Ratings',
            'breadcrumb' => 'Top ASICs',

            'types' => [
                'profit' => [
                    'title' => 'Top most profitable ASICs for today',
                    'description' => 'Daily updated rating of ASIC miners by net profit. Profitability calculator, current prices, specifications, and top high-yield models.',
                    'header' => 'Best mining equipment by profit',
                    'title_prefix' => 'profitable',
                    'header_prefix' => 'by profit',
                    'best_prefix' => 'profitable',
                    'breadcrumb' => 'Profit',
                    'best' => 'The most profitable ASIC at the moment'
                ],
                'payback' => [
                    'title' => 'Top most cost-effective ASICs for today',
                    'description' => 'Rating of ASICs by investment payback speed. Find out which mining equipment will return investments fastest, taking into account current cryptocurrency rates.',
                    'header' => 'Best mining equipment by payback speed',
                    'title_prefix' => 'cost-effective',
                    'header_prefix' => 'by payback speed',
                    'best_prefix' => 'fastest-payback',
                    'breadcrumb' => 'Payback',
                    'best' => 'The fastest-payback ASIC at the moment'
                ]
            ],

            'filters' => [
                'best' => 'The :prefix ASIC at the moment',

                'algorithm' => [
                    'title' => 'The most :prefix ASICs on :filter_value for today',
                    'description' => 'Fresh rating of ASIC miners on the :filter_value algorithm :prefix. Comparison of model profitability, technical parameters, energy efficiency, and equipment prices.',
                    'header' => 'Best :filter_value mining equipment :prefix',
                    'breadcrumb' => ':filter_value',
                ],
                'coin' => [
                    'title' => 'The most :prefix ASICs for mining :filter_value for today',
                    'description' => 'Rating of the best equipment for mining :filter_value crypto coin :prefix. Comparison of hash rate, power consumption, and daily net profit of popular ASIC models.',
                    'header' => 'Best equipment for mining :filter_value :prefix',
                    'breadcrumb' => 'For :filter_value',
                ],
                'price' => [
                    'title' => 'The most :prefix ASICs up to :filter_value rubles for today',
                    'description' => 'Catalog and rating of ASIC miners costing up to :filter_value rubles :prefix. Choose budget-friendly and efficient mining equipment for your starting capital.',
                    'header' => 'Best mining equipment up to :filter_value rubles :prefix',
                    'breadcrumb' => 'Up to :filter_value rubles',
                ],
                'cooling' => [
                    'air' => [
                        'title' => 'air',
                        'description' => 'air',
                        'header' => 'air',
                        'breadcrumb' => 'Air cooling',
                    ],
                    'hydro' => [
                        'title' => 'hydro',
                        'description' => 'water',
                        'header' => 'water',
                        'breadcrumb' => 'Water cooling',
                    ],
                    'immersion' => [
                        'title' => 'immersion',
                        'description' => 'immersion',
                        'header' => 'immersion',
                        'breadcrumb' => 'Immersion cooling',
                    ],
                    'title' => 'The most :prefix :filter_value ASICs for today',
                    'description' => 'Comparison and rating of ASIC miners with :filter_value cooling :prefix. Operating features, noise level, energy efficiency, and current profitability of models.',
                    'header' => 'Best mining equipment with :filter_value cooling :prefix'
                ],
                'home' => [
                    'title' => 'The most :prefix home ASICs for today',
                    'description' => 'Rating of the best quiet ASIC miners for home use :prefix. Comparison of models by noise level, power consumption from a 220V outlet, and payback.',
                    'header' => 'Best mining equipment for home placement :prefix',
                    'breadcrumb' => 'Home ASICs',
                ],
                'new' => [
                    'title' => 'The most :prefix new ASICs for today',
                    'description' => 'Review and rating of new ASIC miners on the market :prefix. The latest and most high-tech equipment from Bitmain, Whatsminer, Avalon with maximum energy efficiency.',
                    'header' => 'Best new mining equipment :prefix',
                    'breadcrumb' => 'New ASICs',
                ]
            ]
        ],

        'hosting' => [
            'best' => [
                'title' => 'Best Mining Hotels: Data Center Rating',
                'description' => 'Up-to-date top of mining hosts by price-to-quality ratio. Compare data centers by electricity rates, security, and placement conditions on Trust Mining.',
                'header' => 'Top Best Hostings for Crypto Mining',
                'breadcrumb' => 'Hostings',
            ],
            'reliable' => [
                'title' => 'Reliable Mining Hotels: Safe Data Center Rating',
                'description' => 'Top of the most reliable hotels for mining with uptime guarantee and a high level of security. Compare equipment placement conditions on Trust Mining.',
                'header' => 'Top Reliable Hostings for Crypto Mining',
                'breadcrumb' => 'Hostings',
            ],
            'cheapest' => [
                'title' => 'Cheapest Mining Hotels: Low-Tariff Data Centers',
                'description' => 'The most inexpensive mining hosts and budget data centers. Compare electricity rates, placement costs and choose the best value on Trust Mining.',
                'header' => 'Top Cheap Hostings for Crypto Mining',
                'breadcrumb' => 'Hostings',
            ],
        ],

        'companies' => [
            'title' => 'Reliable Mining Companies: Vendor & Service Rating',
            'description' => 'Top of the most reliable companies in the mining and cryptocurrency industry. Compare hardware suppliers, mining services and choose trusted partners on Trust Mining.',
            'header' => 'Top Reliable Mining & Crypto Companies',
            'breadcrumb' => 'Companies',
        ],
    ],

    'calculator' => [
        'app' => [
            'title' => 'TrustMining Profitability and Payback Calculator',
            'description' => 'TrustMining online mining calculator: daily profit, payback period, and net income'
        ],
        'show' => [
            'title' => [
                'version' => 'Mining Calculator :model :hashrate:unit: Profitability and Payback',
                'model'   => 'Mining Calculator :model: Profitability and Payback',
                'default' => 'ASIC Mining Calculator: Profitability and Payback',
            ],
            'description' => [
                'version' => 'Find out how much :model :hashrate:unit earns today. Calculate revenue, expenses, profits, and payback periods using our online mining profitability calculator',
                'model'   => 'Find out how much :model earns today. Calculate revenue, expenses, profits, and payback periods using our online mining profitability calculator',
                'default' => 'Calculate revenue, expenses, profits, and payback periods for ASIC miners using our online mining profitability calculator',
            ],
        ]
    ],

    'privacy' => [
        'title' => 'TrustMining Privacy Policy',
        'description' => 'TrustMining Privacy Policy: rules for collecting, storing, and protecting user personal information, cookie usage, and data security guarantees',
        'header' => 'Personal Data Processing Terms'
    ],

    'terms' => [
        'title' => 'TrustMining Terms of Service',
        'description' => 'TrustMining Terms of Service: rules for platform usage, rights and obligations of users, liability of parties, and website service conditions',
        'header' => 'Terms of Service'
    ],

    'roadmap' => [
        'title' => 'TrustMining Roadmap - Project Development Plans',
        'description' => 'Explore the official TrustMining project roadmap. Learn about platform development plans, new mining tool launches, update schedules, and our team\'s strategic goals'
    ],

    'about' => [
        'title' => 'What is TrustMining: Project Mission and Goals',
        'description' => 'Discover the core ideas behind the TrustMining project. Together, we can make the crypto industry a safer place',
        'header' => 'About TrustMining Service'
    ],

    'home' => [
        'title' => 'TrustMining - Platform About Mining and Cryptocurrencies',
        'description' => 'An independent service for evaluating company reliability, essential tools for miners, metrics for crypto enthusiasts, ASIC reviews, an expert forum, and a media space'
    ],

    'support' => [
        'title' => 'Support, Frequently Asked Questions | TRUSTMINING',
        'description' => 'User Support Center: answers to frequently asked questions about purchases and account settings. Dashboard guidelines and instructions'
    ],

    'legal' => [
        'title' => 'Cryptocurrency and Mining Lawyer | TRUSTMINING',
        'description' => 'Professional legal assistance in digital financial assets (DFA), anti-money laundering regulations compliance, protection against crypto scams, and mining hardware deals support'
    ],

    'notification' => [
        'title' => 'Notification History | TRUSTMINING',
        'description' => 'View your notification history on the TrustMining platform'
    ],

    'insight' => [
        'title' => 'Crypto News and Mining Articles | TM Insight',
        'description' => 'TM Insight is a leading crypto and mining media platform. Expert articles, market analysis, trading, hardware, and corporate channels',

        'channel' => [
            'create' => [
                'title' => 'Create Your Channel | TM Insight',
                'description' => 'Create a channel on the TM Insight platform and start writing articles, publishing posts, and sharing videos',
                'header' => 'Channel Creation'
            ],
            'edit' => [
                'title' => 'Edit Your Channel | TM Insight',
                'description' => 'Edit your channel on the TM Insight platform and continue writing articles, publishing posts, and sharing videos',
                'header' => 'Edit Channel'
            ]
        ],
        'content' => [
            'video' => [
                'index' => [
                    'title' => 'Trading Analytics, Video Reviews | TM Insight',
                    'description' => 'TM Insight features videos from leading media and creators: news, trading analytics, and miner reviews. Watch the highlights in a convenient format'
                ],
                'create' => [
                    'title' => 'Add Video | TM Insight',
                    'description' => 'Add a video on the TrustMining | TM Insight website',
                    'header' => 'Add Video'
                ]
            ],
            'article' => [
                'index' => [
                    'title' => ':tag Articles and Guides | TM Insight',
                    'description_part' => 'about cryptocurrency and mining',
                    'description_tag' => 'by hashtag',
                    'description' => 'Read useful and relevant :tag articles. TM Insight aggregates content from leading companies and expert authors',
                    'header_tag' => 'on :tag topic'
                ],
                'create' => [
                    'title' => 'Create Article | TM Insight',
                    'description' => 'Create your article and review on the TrustMining | TM Insight website',
                    'header' => 'Write Article'
                ]
            ],
            'post' => [
                'index' => [
                    'title' => 'Crypto Market and Corporate News | TM Insight',
                    'description' => 'Stay updated with the latest news and events in the crypto and mining industries. TM Insight aggregates valuable materials from leading companies and expert authors'
                ],
                'create' => [
                    'title' => 'Create Post | TM Insight',
                    'description' => 'Publish a news or informational post on the TrustMining | TM Insight website',
                    'header' => 'Write Post'
                ]
            ]
        ]
    ],

    'profile' => [
        'title' => 'Dashboard, Company Profile | TRUSTMINING',
        'description' => 'Your personal dashboard: manage your company profile and monitor your balance. Edit your data and manage all services'
    ],

    'ad' => [
        'create' => [
            'title' => 'Create Listing | TRUSTMINING',
            'description' => 'Post a listing to sell mining hardware or offer any service in the mining and cryptocurrency sector on the TrustMining website',
            'header' => 'Create Listing'
        ],
        'edit' => [
            'title' => 'Edit Listing | TRUSTMINING',
            'description' => 'Edit your listing for mining hardware sales or any service in the mining and cryptocurrency sector on the TrustMining website',
            'header' => 'Edit Listing'
        ],
        'edit_mass' => [
            'title' => 'Edit Prices | TRUSTMINING',
            'description' => 'Edit the prices of listings for mining hardware sales or any service in the mining and cryptocurrency sector on the TrustMining website',
            'header' => 'Edit Price List'
        ],
        'statistics' => [
            'title' => 'Listing Statistics',
            'description' => 'Listing performance reports'
        ]
    ],

    'hosting' => [
        'index' => [
            'title' => 'Mining Hotel Catalog | TRUSTMINING',
            'description' => 'Find the best mining hotel: reliability analysis, current rates, detailed terms, and reviews on the TrustMining website',
            'header' => 'Mining Hosting'
        ],
        'show' => [
            'title' => 'Mining Hotel :name - Mining Hosting',
            'description' => 'Host your equipment with :name at the rate of :tariff ₽/kW. Reliability analysis, photos, prices, and terms on the Trust Mining website'
        ],
        'create' => [
            'title' => 'Mining Hotel: Create Hosting Listing',
            'description' => 'Create a hosting listing on the TrustMining website'
        ],
        'edit' => [
            'title' => 'Mining Hotel: Edit Hosting Listing',
            'description' => 'Edit a hosting listing on the TrustMining website'
        ]
    ],

    'company' => [
        'index' => [
            'title' => 'Mining Companies: Information, Price Lists, Reviews',
            'description' => 'A list of the best mining companies in Russia and worldwide. Current reviews from real clients. Compare companies by prices, services, and reputation'
        ],
        'edit' => [
            'title' => 'Edit Company Information | TRUSTMINING',
            'description' => 'Add a description, photos, and a logo to your company profile on the TrustMining website'
        ],
        'show' => [
            'title' => ':name: Company Information and Reviews',
            'description' => 'Company profile, real reviews, and reliability analysis. Explore all details about :name on the TrustMining website'
        ],
        'shop' => [
            'title' => 'ASIC Miners and Services Catalog by :name',
            'description' => 'Current price list of :name, data center information, and company details on the TrustMining website'
        ]
    ],

    'office' => [
        'create' => [
            'title' => 'Add Office, Point of Sale | TRUSTMINING',
            'description' => 'If you have an office, point of sale, production facility, or any other location where you can meet potential clients, add it here',
            'header' => 'Add Office'
        ],
        'edit' => [
            'title' => 'Edit Office, Point of Sale | TRUSTMINING',
            'description' => 'Edit your created office or point of sale',
            'header' => 'Edit Office'
        ],
        'show' => [
            'title' => ':name Company Office in :city',
            'description' => 'Visit the official office of :name in :city. Find the address and opening hours right now on the TrustMining website',
            'header' => ':name Company Office'
        ],
        'index' => [
            'title' => 'Company Offices: Addresses and Reviews | TRUSTMINING',
            'description' => 'Current addresses of company offices, service centers, crypto exchangers, and points of sale on the TrustMining website',
        ],
        'services' => [
            'title' => 'Mining Hardware Repair Services',
            'description' => 'Service centers for ASIC and graphics card (GPU) repair. Find the nearest service center in your city on the TrustMining website',
        ],
        'exchangers' => [
            'title' => 'Crypto Exchangers: Cryptocurrency Exchange',
            'description' => 'Find where to exchange cryptocurrency for fiat in your city. Current rates and real reviews on the TrustMining website',
        ],
        'shop' => [
            'title' => 'Official Offices of :name',
            'description' => 'Office addresses, current stock of ASIC miners, and prices at :name points of sale on the TrustMining website',
        ],
    ],

    'auth' => [
        'forgot_password' => [
            'title' => 'Password Recovery | TRUSTMINING',
            'description' => 'Recover your TrustMining account password to regain access to company listings, mining equipment, and the expert community'
        ],
        'reset_password' => [
            'title' => 'Reset Password | TRUSTMINING',
            'description' => 'Reset your password on the TrustMining website'
        ],
        'verify_email' => [
            'title' => 'Email Verification | TRUSTMINING',
            'description' => 'Verify your email address to complete your registration on TrustMining and gain full access to the platform'
        ],
        'login' => [
            'title' => 'Authorization - Dashboard Login | TRUSTMINING',
            'description' => 'Log in to the TrustMining website - sign in for miners and clients of infrastructure companies. Access the professional mining ecosystem'
        ],
        'register' => [
            'title' => 'Account Registration | TRUSTMINING',
            'description' => 'Create an account on the TrustMining website and gain access to the catalog of mining hardware and service companies within the crypto ecosystem'
        ]
    ],

    'metrics' => [
        'title' => 'Cryptocurrency Metrics and Indicators | TRUSTMINING',
        'description' => 'Cryptocurrency analytics and statistics. Network difficulty metrics, hashrate of popular coins, and current cryptocurrency rates in real-time',

        'coin' => [
            'title' => 'Crypto Coin Rates and Metrics | TRUSTMINING',
            'description' => 'Track cryptocurrency prices online. Current coin rates, price change charts, and market analytics in real-time',
            'header' => 'Coin Metrics',

            'rate' => [
                'title' => ':name Exchange Rate: Online Chart and History',
                'description' => 'Current :pair exchange rate today. Price history by days and years, real-time rate dynamics, and currency converter',
            ]
        ],
        'network' => [
            'title' => 'Crypto Network Metrics and Statistics | TRUSTMINING',
            'description' => 'Current indicators of blockchain networks. Mining difficulty and total network hashrate of Bitcoin, Litecoin, and other popular cryptocurrencies',
            'header' => 'Crypto Network Metrics',

            'difficulty' => [
                'title' => ':name Network Difficulty Today: Forecast, Online Chart',
                'description' => 'Current mining difficulty of the :name (:abbreviation) network. Chart, historical changes, and real-time forecast for the next difficulty retarget'
            ],
            'hashrate' => [
                'title' => 'Current :name Network Hashrate: History and Chart',
                'description' => 'Historical changes and current hashrate metrics of the :name (:abbreviation) crypto network'
            ]
        ]
    ],

    'blog' => [
        'title' => 'TrustMining Blog: Articles, Mining News',
        'description' => 'News blog by TrustMining. Only the most interesting and relevant articles',
    ],

    'forum' => [
        'title' => 'Cryptocurrency and Mining Forum | TRUSTMINING',
        'description' => 'Expert tips and professional solutions to your problems. Create your own discussion topics, exchange experiences, and get answers to your questions',

        'category' => [
            'description' => 'Expert tips and professional solutions from the :category section on the TrustMining forum'
        ],
        'subcategory' => [
            'description' => 'Expert tips and professional solutions regarding :subcategory from the :category section on the TrustMining forum'
        ],
        'question' => [
            'index' => [
                'title' => 'Questions List | TRUSTMINING Forum',
                'description' => 'A complete list of all questions on the TrustMining forum',
                'header' => 'All Forum Questions'
            ],
            'my' => [
                'title' => 'List of Your Questions and Topics | TRUSTMINiNG Forum',
                'description' => 'View your question history, track the moderation process, and check out similar discussions'
            ],
            'create' => [
                'title' => 'Create a Discussion Topic | TRUSTMINING Forum',
                'deescription' => 'Describe your issue or start a discussion on any crypto topic that interests you on the TrustMining forum',
                'header' => 'Create Question'
            ]
        ]
    ],

    'database' => [
        'genset' => [
            'title' => 'Gas Generator Catalog',
            'description' => 'Current database of gas generator power plants. Prices, specifications, real reviews, and photos on the TrustMining website',

            'brand' => [
                'title' => ':brand Gas Generators | TRUSTMINING',
                'description' => 'Gas generator power plants from the manufacturer :brand. Prices, specifications, real reviews, and photos on the TrustMining website'
            ],
            'model' => [
                'title' => ':brand :name Gas Generator :power kWh',
                'description' => 'Gas generator power plant :brand :name rated at :power kWh. Specifications, reviews, and current supplier offers on the TrustMining website'
            ]
        ],
        'asic' => [
            'title' => 'List of All Existing ASIC Miners | TRUSTMINING',
            'description' => 'Up-to-date ASIC database. Specifications and current profitability metrics on the TrustMining website',

            'brand' => [
                'title' => 'All :brand ASIC Miners | TRUSTMINING',
                'description' => 'A complete database of all ASIC miners from the manufacturer :brand. Specifications and current profitability metrics on the TrustMining website'
            ],
            'model' => [
                'title' => ':b :n :h:m/s - ASIC Review',
                'description' => 'Technical specifications of the :b :n ASIC miner. Current profitability, today\'s payback period, and price comparison from suppliers on the TrustMining website'
            ],
            'compare' => [
                'title' => 'Difference Between :modelA and :modelB',
                'description' => 'Detailed comparison of the :brandA :modelA and :brandB :modelB ASIC miners by specifications, profitability, current prices, and payback periods'
            ]
        ]
    ],

    'wiki' => [
        'title' => 'TM Wiki - Crypto Glossary and Knowledge Base',
        'description' => 'At TM Wiki, we have gathered all the information you need to understand cryptocurrency and mining. Beginners can learn the fundamentals, while professionals can deepen their knowledge.',
        'header' => 'TM Wiki',

        'dictionary' => [
            'title' => 'Crypto & Mining Terms and Definitions | TM Wiki',
            'description' => 'Explore essential crypto slang and mining terminology in the specialized TM Wiki section on the TrustMining website.',
            'header' => 'Crypto Dictionary',
        ]
    ],

    'order' => [
        'create' => [
            'title' => 'TrustMining Dashboard Balance Top-Up',
            'description' => 'Instructions and forms to top up your TrustMining account balance. Choose a convenient method and continue using our services seamlessly'
        ]
    ],

    'roulette' => [
        'prizes' => [
            'title' => 'List of All Giveaways',
        ]
    ],

    'hashrate-converter' => [
        'title' => 'Hashrate Converter | Convert hash, Mh, Gh, Th, Sol',
        'description' => 'A universal online calculator for converting miner computing power. Easily convert hashes (H/s), solutions (Sol/s), and Graphs/s on TrustMining.',
    ],

    'tariff' => [
        'index' => [
            'title' => 'TrustMining Service Rates and Pricing',
            'description' => 'Current rates for promoting your products and services on the largest platform for miners'
        ],
        'show' => [
            'title' => 'Purchase :name Subscription | TRUSTMINING',
            'description' => 'Get a :name subscription for professional work in the mining market. Scale your business with us'
        ]
    ],

    'taxes' => [
        'title' => 'Crypto Mining and Turnover Taxes in Russia',
        'description' => 'A comprehensive guide to mining taxation in Russia. Individuals, sole proprietors, LLCs, tax calculation, declarations, documents, and case studies'
    ],

    'warranty' => [
        'title' => 'Warranty Check for Bitmain, Whatsminer, and Other ASICs',
        'description' => 'Check remaining warranty for Whatsminer, Bitmain, Canaan, Iceriver, and Jasminer ASIC miners',
        'header' => 'Check Warranty by Serial Number'
    ],

    'api' => [
        'title' => 'TrustMining API Documentation',
        'description' => 'A comprehensive guide to using the TrustMining API. Build your custom integration'
    ],

    'chat' => [
        'title' => 'Messages | TRUSTMINING',
        'description' => 'Online chat on the TrustMining website'
    ],

    'widjets' => [
        'title' => 'Website Widgets | TRUSTMINING',
        'description' => 'Add convenient tools for miners from TrustMining to your resource. Instructions on using iframe widgets and customizing parameters'
    ],

    'review' => [
        'index' => [
            'title' => [
                'user' => 'Reviews for :name | TRUSTMINING',
                'asic' => 'Reviews for ASIC :brand :model | TRUSTMINING',
                'gpu' => 'Reviews for Gas Generator :brand :model | TRUSTMINING',
            ],
            'description' => [
                'user' => 'Real reviews for :name from clients and experts: service quality, reliability, and overall experience on the TrustMining platform',
                'asic' => 'Miners\' reviews for the :brand :model ASIC: real operating experience, profitability, reliability, and expert opinions on TrustMining',
                'gpu' => 'Miners\' reviews for the :brand :model gas generator power plant: real operating experience and reliability on TrustMining',
            ],
        ],
    ]
];
