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
        'main' => 'Currently, the :brand :model :version generates around :incomeU USDT (:incomeR RUB) in revenue per day. With an electricity tariff of :tariff ₽/kWh, daily power costs amount to :expenseU USDT (:expenseR RUB). After accounting for electricity costs and pool fees, the estimated net mining profit is :profitU USDT (:profitR RUB) per day.',
        'tax' => 'Based on the selected tax settings, the estimated mining tax for the :brand :model :version is :taxU USDT (:taxR RUB) per day, :taxMonthU USDT (:taxMonthR RUB) per month, and :taxYearU USDT (:taxYearR RUB) per year. After taxes, the estimated net profit is :profitAfterTaxU USDT (:profitAfterTaxR RUB) per day, or :profitAfterTaxMonthU USDT (:profitAfterTaxMonthR RUB) per month. Tax calculations depend on the selected tax system and configured parameters.',
        'payback' => [
            'have' => 'The best offer to purchase the :brand :model :version on the TrustMining platform is currently provided by :seller at a price of :price USDT (:priceR RUB) including VAT. Based on current mining profitability, the estimated ASIC payback period is :payback days. This metric is speculative and may change along with cryptocurrency rates, network difficulty, mining revenue, power costs, taxes, and other parameters.',
            'not' => 'Currently, there are no available offers to purchase the :brand :model :version on the TrustMining platform, so the calculator cannot determine the current ASIC payback period. You can check out available offers for the :model model with a different hashrate via the link.',
        ],
        'firmware' => 'For the :brand :model :version, the most profitable available firmware is :firmware. When using it, the hashrate is :firmwareHashrate :firmwareUnit, power consumption is :firmwarePower W, and energy efficiency is :firmwareEfficiency J/:firmwareUnit. The estimated mining profit is :firmwareProfitU USDT (:firmwareProfitR RUB) per day, which is :firmwareIncreaseU USDT (:firmwareIncreaseR RUB), or :firmwareIncreasePercent%, higher than the current result.',
        'params' => 'To calculate mining profitability, the TrustMining calculator uses live crypto network data and hardware specifications. The calculation includes the electricity tariff (:tariff ₽/kWh), ASIC energy efficiency (:efficiency), consumption of the :model model version :version (:power W), current revenue of all available coins for the :algorithm algorithm (:coins), mining pool commission (:comission%), and equipment uptime (:uptime%). The calculation can also account for the ASIC price, tax parameters, and the impact of available firmware options on hashrate, power consumption, and final mining profitability.',
        'summary' => 'In summary, the TrustMining calculator evaluates not only cryptocurrency mining revenue but also the key expenses and factors affecting ASIC profitability. The calculation factors in live network data, hardware specifications, power costs, pool fees, taxes, ASIC prices, and firmware configurations to provide a comprehensive view of mining economics.',
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
    ],

    'ad' => [
        'conditions' => [
            'new_miner' => 'new',
            'used_miner' => 'used',
            'new_gpu' => 'new',
            'used_gpu' => 'used',
        ],
        'availability' => [
            'preorder' => 'on pre-order with a waiting time up to :days days',
            'stock' => 'from stock',
        ],

        'miner_desc' => "<p>:user offers a <b>:condition</b> ASIC miner <b>:brand :model</b> with a hashrate of <b>:hashrate :measurement</b> in <b>:city</b>.</p><p>Equipment is available <b>:availability</b>.</p><p><br /></p>Check availability and delivery terms with the seller by contacting them in our online chat or by phone.",
        'gpu_desc' => "<p>:user offers a <b>:condition</b> gas generator set <b>:brand :model</b> with a maximum power of <b>:power kWh</b> in <b>:city</b>.</p><p>GPU is available <b>:availability</b>.</p><p><br /></p>Check availability and delivery terms with the seller by contacting them in our online chat or by phone.",
    ],

    'asic' => [
        'text_p1' => 'The <b>:model</b> model from the world\'s leading manufacturer <b>:brand</b> is a high-performance solution designed for professional mining. This device combines advanced chip architecture, exceptional reliability, and optimized power consumption, making it one of the most sought-after tools in the digital asset mining industry. The model was released in :release.',

        'h2_specs' => 'Technical Specifications and Performance',
        'text_specs_p1' => 'The <b>:model</b> is powered by innovative components that ensure stable operation even under peak loads.',
        'text_specs_p2' => 'Key metrics of the device:',

        'labels' => [
            'algorithm' => 'Algorithm:',
            'hashrate' => 'Hashrate:',
            'power' => 'Power Consumption:',
            'efficiency' => 'Energy Efficiency:',
        ],

        'specs' => [
            'algorithm' => 'Operates on the <b>:algorithm</b> algorithm, which has proven to be one of the most secure and profitable in the network.',
            'hashrate' => 'The nominal computing power is <b>:hashrate</b>, allowing it to compete effectively in today\'s network complexity conditions.',
            'power' => 'The device power consumption is locked at <b>:power W</b>, providing a perfect balance between performance and electricity costs.',
            'efficiency' => 'The efficiency metric stands at <b>:efficiency J/TH</b>, which is a key factor for a fast return on investment.',
        ],

        'h2_assets' => 'Supported Assets',
        'text_assets' => 'Due to the <b>:algorithm</b> algorithm, this miner allows you to mine a wide range of cryptocurrencies. The list of the most relevant coins includes: <b>:coins</b>. This gives the owner flexibility in choosing a mining strategy and the ability to switch between assets depending on the current market situation.',

        'h2_cooling' => 'Cooling System and Operating Conditions',
        'text_cooling' => 'The operational stability of an ASIC miner directly depends on the quality of heat dissipation. This model features an advanced cooling system.',

        'cooling_types' => [
            'Air' => 'The <b>air cooling</b> system is equipped with high-RPM fans that create a powerful directed airflow through the chip heatsinks. This is a classic and most reliable solution that does not require complex maintenance. It is ideal for deployment in specially equipped containers or data centers with high-quality supply and exhaust ventilation. The chassis is designed to minimize hot air stagnation zones, extending the lifespan of the components.',
            'Hydro' => 'The <b>hydro cooling</b> system utilizes special water blocks for direct heat dissipation from the hashboards. This allows completely eliminating noisy fans, making the device operation virtually silent. Hydro systems handle overheating significantly better, allowing the miner to be operated in regions with hot climates or allowing waste heat to be used for space heating. This type of cooling requires connection to an external water loop or cooling tower.',
            'Immersion' => 'The device is prepared for submersion into a specialized dielectric liquid. <b>Immersion cooling</b> is the pinnacle of engineering thought in mining. The liquid envelops all components, ensuring uniform heat dissipation and protecting the hashboards from dust, moisture, and static electricity. This eliminates the risk of local overheating ("hot spots") and allows for safe overclocking, increasing the hashrate above factory settings while maintaining a stable temperature.',
        ],

        'h2_advantages' => 'Advantages of the :model model',
        'advantages' => [
            'durability' => '<b>Durability:</b> The use of high-quality chassis materials and wear-resistant components guarantees a long equipment lifecycle.',
            'management' => '<b>Intelligent Management:</b> The built-in software allows tracking chip status, fan rotation speed (if applicable), and current revenue in real-time.',
            'setup' => '<b>Fast Configuration:</b> An intuitive web interface allows launching the mining process just a few minutes after the first power-up.',
        ],

        'h2_summary' => 'Summary',
        'text_summary' => '<b>:brand :model</b> is the benchmark of quality in the mining world. The device is perfectly suited both for scaling existing farms and for those looking for the most effective solution to start. A high hashrate combined with clever power consumption makes this model a strategically advantageous acquisition for the long-term perspective.',
    ],

    'genset' => [
        'text_p1' => 'The <b>:model</b> gas piston power plant (GPES) from the world\'s leading brand <b>:brand</b> (country of manufacture — <b>:country</b>) is a highly technological solution for creating autonomous and backup power supply systems. This installation is designed to provide maximum energy independence for industrial enterprises, commercial facilities, and large mining hotels.',

        'h2_specs' => 'Technical Specifications and Power',
        'text_specs_p1' => 'The :model model features high performance and adaptability to challenging operational conditions.',

        'labels' => [
            'max_power' => 'Maximum Power:',
            'phases' => 'Electrical Parameters:',
            'economy' => 'Efficiency:',
            'volume' => 'Displacement:',
            'configuration' => 'Configuration:',
            'rpm' => 'Operating Speed:',
        ],

        'specs' => [
            'max_power' => 'The plant is capable of delivering up to <b>:power :unit</b>, which allows powering heavy equipment without voltage drops.',
            'phases' => 'The system generates electricity in a :phases-phase mode, ensuring a stable sine wave and frequency required for sensitive electronics.',
            'economy' => 'An advanced air-fuel mixing system ensures optimized fuel consumption. Gas consumption is <b>:consumption</b>, making the cost per kWh significantly lower than using main power grids or diesel alternatives.',
        ],

        'h2_engine' => 'Power Unit: The Heart of the System',
        'text_engine_p1' => 'The reliability of the power plant directly depends on the engine specifications. This model utilizes an industrial <b>:model</b> gas piston engine from the legendary manufacturer <b>:brand</b> (<b>:country</b>).',
        'h3_engine_title' => 'The engine possesses the following design features:',

        'engine_specs' => [
            'volume' => '<b>:volume</b>, which guarantees high torque and stability under load.',
            'cylinders' => 'The engine features <b>:cylinders</b> cylinders arranged to minimize vibration and mechanical wear.',
            'rpm' => 'The rotation speed is <b>:rpm</b> rpm. This is the optimal mode for extended continuous operation (24/7), ensuring an increased overhaul interval (operational lifespan).',
        ],

        'h2_advantages' => 'Advantages of <b>:brand</b> Gas Piston Technology',
        'advantages' => [
            'cost' => '<b>Low Energy Cost:</b> Utilizing natural gas (or associated petroleum gas) reduces electricity expenses by 2-3 times compared to grid utility tariffs.',
            'ecology' => '<b>Eco-Friendliness:</b> <b>:brand</b> gas piston engines comply with strict international environmental standards for NOx and CO emissions.',
            'cogen' => '<b>Cogeneration Capability:</b> The <b>:model</b> plant can be retrofitted with a heat recovery system, allowing free thermal energy generation for space heating or industrial processes.',
            'durability' => '<b>Durability:</b> Industrial components and precision assembly in <b>:country</b> ensure an equipment lifespan of tens of thousands of operating hours before a major overhaul.',
        ],

        'h2_safety' => 'Safety and Control',
        'text_safety' => 'The plant is equipped with a modern microprocessor control panel that automatically monitors all critical parameters: gas pressure, coolant temperature, oil level, and output power quality. The protection system reacts instantly to any anomalies, preventing equipment damage.',

        'h2_usage' => 'Applications',
        'text_usage' => 'Combining a high power of :power :unit and a reliable :engine_model engine, this GPU is an ideal choice for:',

        'usage_list' => [
            'f1' => 'Manufacturing workshops and plants;',
            'f2' => 'Large data centers (DCs);',
            'f3' => 'Oil and gas sector facilities;',
            'f4' => 'Mining farms requiring stable and cheap electricity.',
        ],

        'h2_summary' => 'Summary',
        'text_summary' => 'By choosing the <b>:brand :model</b> gas piston power plant, you are investing in a reliable asset that will power your enterprise for many years to come. This is a time-tested solution combining a solid engineering background with modern energy-efficiency technologies.',
    ]
];
