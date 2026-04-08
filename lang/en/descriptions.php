<?php

return [
    'compare' => [
        'intro' => [
            'same_brand' => [
                'We are comparing two devices from :b1 — models :m1 (:d1) and :m2 (:d2).',
                'Manufacturer :b1 introduced both models (:m1 and :m2) at different times, and today we will analyze their key differences.',
                'In the :b1 lineup, models :m1 and :m2 occupy different niches despite their similar origin.'
            ],
            'old_gen' => [
                'We are reviewing time-tested solutions :m1 and :m2. Despite the release of new generations, these models are still active on the market.',
                'Let\'s compare how relevant :m1 is compared to :m2 in current conditions.',
            ],
            'diff_brand' => [
                'Today in the battle we have :m1 from :b1 against competitor :b2\'s :m2.',
                'The choice between :b1 :m1 and :b2 :m2 is a classic dilemma for mining investors.',
            ]
        ],
        'algo' => [
            'same' => [
                'Both devices operate on :a1, mining :all1. The main profit focus is currently on :c1.',
                'The unified algorithm (:a1) allows switching between coins (:all1) on both ASICs, but maximum profit is currently achieved when mining :c1.',
            ],
            'diff' => [
                'Different algorithms (:a1 vs :a2) mean different strategies: :m1 mines :c1, while :m2 is focused on :c2.',
                ':m1 and :m2 cannot be directly compared by hashrate as they operate on different protocols: :a1 and :a2 respectively.',
            ]
        ],
        'hashrate' => [
            'one' => [
                ':b :m is released in a single version with :hashrate.',
                'Model :m from manufacturer :b is a unique solution with :hashrate power, available in a single version.',
                'Model :b :m is presented exclusively in a configuration with :hashrate, other power options are not provided for this series.',
                'The :m device has a single available configuration — :hashrate'
            ],
            'more' => [
                ':b :m has several versions, with hashrate starting from :minhashrate and going up to :maxhashrate.',
                'The :b :m lineup includes :count modifications: starting performance is :minhashrate, while top solutions reach :maxhashrate.',
                'The :m device from :b is available in a wide range of powers. Versions from :minhashrate to :maxhashrate are available.',
                'Choose the right :m version for your needs from :count options with power ranging from :minhashrate to :maxhashrate inclusive.'
            ],
            'diff' => [
                'The difference in computing power is :diffPercent%, but the final advantage can only be shown by the energy efficiency of the equipment. Model :m1 has :e1, while :m2 has :e2.',
                'The difference in :diffValue shows the advantage of one model, but it\'s also worth paying attention to the efficiency of the models. Model :m1 has an efficiency of :e1 and :m2 has :e2.'
            ]
        ],
        'power' => [
            'diff' => [
                'Model :m1 has a power consumption of :p1 Watts, while :m2 consumes :p2 Watts.',
                'The power consumption of :b1 :m1 is :p1 Watts. :b2 :m2, in turn, consumes :p2 Watts.'
            ]
        ],
        'cooling' => [
            'same_Air' => [
                'Both miners use air cooling, which requires good room ventilation.',
                'The cooling type for both models is identical — classic fan airflow.',
            ],
            'same_Hydro' => [
                'Both miners belong to the Hydro series and require connection to a water cooling system. This ensures minimal noise levels and stable hashrate even in hot climates.',
                'Using water cooling on :m1 and :m2 allows for efficient heat dissipation from chips, significantly extending equipment lifespan compared to air-cooled counterparts.',
                'To operate these Hydro edition models, you need an external cooling system (cooling tower). In return, you get the ability to place equipment in rooms without powerful ventilation.',
                'Hydro technology in models :m1 and :m2 prevents dust accumulation inside the case, which is a critical advantage for 24/7 stable operation.',
            ],
            'same_Immersion' => [
                'Both models are designed to work in immersion baths. This guarantees no noise and perfect heat dissipation for chips.',
                'These devices (Immersion edition) require immersion in dielectric coolant, allowing :m1 and :m2 to operate in enclosed spaces without powerful exhaust systems.',
                'Using immersion cooling on both ASICs opens up opportunities for safe overclocking and extending component lifespan.',
            ],
            'diff' => [
                'There is a fundamental difference in cooling type: :m1 uses :c1, while :m2 operates on :c2.',
                'Miner :m1 (:c1) will significantly differ in noise level from :m2 (:c2).',
            ]
        ],
        'ads' => [
            'have' => [
                'Our platform has :count offers of :b :m from different companies, available both in stock and on order. The best price for the :hashrate version is currently :price.',
                'Compare :count offers for :b :m from verified suppliers. Right now, the :hashrate configuration can be purchased at the minimum price of :price.',
                ':count ads found for :b :m. The current cost for :hashrate power is from :price. Both new and used devices are available.',
                ':count active listings available for :b :m. The best price-to-performance ratio: :hashrate for :price.',
            ],
            'not' => [
                'Currently, there are no :b :m offers on the platform. If you are interested in this model, you can contact us or one of the verified companies listed on our platform.',
                'Offers for :b :m are temporarily unavailable, but our catalog contains many other profitable models.',
                'Unfortunately, :m is currently not available either in stock or on order. Please try looking at other models.'
            ]
        ]
    ],
    'calculator' => [
        'main' => 'Currently, :brand :model :version generates :incomeU USDT (:incomeR RUB) per day, with daily electricity costs at the :tariff R/kWh rate amounting to :expenseU USDT (:expenseR RUB). The final daily net profit is :profitU USDT (:profitR RUB).',
        'payback' => [
            'have' => 'On the TrustMining platform, the best offer to purchase :brand :model :version is currently an ad from :seller at a price of :price USDT. Based on this, we can estimate the approximate payback period as :payback days. Please note that the payback period is an estimate and is only valid at current coin rates and today\'s network difficulty.',
            'not' => 'Unfortunately, there are currently no offers to purchase :brand :model :version on the TrustMining platform, so we cannot estimate the payback period. Please check the ads for :model with different hashrate specifications at the link below.',
        ],
        'params' => 'For the most accurate calculation, the TrustMining profitability calculator took into account parameters such as: electricity price (:tariff R per kilowatt), model energy efficiency (:efficiency), power consumption of the :model :version (:power watts), and current profitability for all coins mineable on the :algorithm algorithm: :coins. The TrustMining calculator also considers additional parameters: mining pool fee (:comission%) and hardware uptime (:uptime%).'
    ],
    'can_trust' => [
        'trust' => [
            'green' => 'The Trust system has determined that the seller :seller can be fully trusted, based on the positive factors listed below.',
            'yellow' => 'TrustMining security algorithms indicate that the seller :seller can be trusted, but you should pay attention to some risks listed below.',
            'red' => 'We have analysed numerous facts about :seller and can say that you should start working with this seller only after clarifying some details regarding the risks listed below.'
        ],
        'company' => [
            'llc' => 'The seller is a legal entity. The company :name is registered :registration.',
            'ip' => 'The seller operates on behalf of :name, registered :registration.',
            'person' => 'The seller does not have a verified legal entity or registered individual entrepreneur. This is worth paying close attention to when deciding whether to cooperate.',
            'registration' => [
                '>4' => 'The company’s registration date indicates extensive experience and allows this parameter to be completely removed from the risk list.',
                '2-4' => 'The company has been on the market for more than two years. This does not completely eliminate cooperation risks, but it does increase the level of trust in this seller.',
                '<1' => 'The seller has been operating for less than a year. This does not mean that they cannot be trusted, but it also does not provide an opportunity to raise their trust score.'
            ],
            'employers' => [
                'have' => 'There are :count employee officially employed at :seller company.|There are :count employees officially employed at :seller company.|There are :count employees officially employed at :seller company.',
                '>10' => 'Having this number of employees significantly increases confidence in the seller’s добросовестной (in good faith) operations.',
                '4-10' => 'Fraud schemes usually do not involve officially hiring employees, so we can increase the trust score for this seller.',
                '1-4' => 'Officially employing a few employees does not increase trust in the seller. One might think this is an attempt to give the appearance of legitimacy to fraudulent activities, but there may be other reasons.',
                'not' => 'There are no officially employed employees at :seller company, which, according to the TrustFactor formula, lowers the level of trust in the seller.',
                'registration' => 'Do not forget that the seller has been on the market for less than two years. This is a stage of organisational development where there may not yet have been an opportunity to officially hire employees.'
            ]
        ],
        'offices' => [
            'many' => 'The seller operates in :count cities.',
            'one' => 'The seller has a single office in the city of :city. This is not an indicator.'
        ],
        'unique_content' => [
            'unique' => 'The company’s listings use original content. That is, the seller does not simply take all images from the internet, but conducts their own photo shoots or at least creates unique preview designs.',
            'not' => 'Most images in the seller’s listings are taken from the internet, which is clearly not a sign of a large, trustworthy company.'
        ],
        'conclusion' => [
            'The formula for assessing trust in a seller takes into account more than 40 criteria: from public reputation and reviews to information about the company’s official revenues. We do not provide a full list of formula parameters to avoid giving unscrupulous companies instructions on how to artificially boost their Trust Factor score.',
            'The seller`s trust rating is based on 40+ indicators, including reviews, online reputation, and official financial reporting. We keep the specific Trust Factor algorithm confidential to prevent manipulation by bad actors and to ensure a fair and impartial assessment.',
            'The Trust Factor is calculated automatically using 40 criteria, ranging from review analysis to company revenue data. The full list of parameters is not disclosed to protect the system from artificial inflation and to provide users with reliable information on seller credibility.',
            'We evaluate seller reliability based on more than 40 parameters—everything from their reputation and reviews to official financial transparency. To make sure no one can "hack" the system or artificially boost their Trust Factor, we do not go public with the full list of criteria. This keeps your shopping experience safe and honest.'
        ]
    ]
];
