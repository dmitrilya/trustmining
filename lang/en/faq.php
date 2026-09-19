<?php

return [
    'metrics' => [
        'network' => [
            'difficulty' => [
                'question_1' => 'What is network difficulty for :name (:short)?',
                'answer_1' => 'The :name difficulty is a parameter that determines how difficult it is to find a new block in the :short blockchain. It is automatically adjusted according to the protocol rules to maintain the target block generation rate. You can also learn more about this topic in our article',
                'question_2' => 'How often is :short difficulty adjusted?',
                'answer_2' => 'The difficulty adjustment period depends on the protocol of each cryptocurrency. For example, the Bitcoin network adjusts its difficulty every 2016 blocks to keep the average block generation time close to its target value.',
                'question_3' => 'How does an increase in :name difficulty affect mining?',
                'answer_3' => 'An increase in :short difficulty means that more computational work is required to find a new block. With the network hashrate and other conditions unchanged, this generally reduces the mining profitability of individual mining hardware.',
                'question_4' => 'Where can I see the current :short difficulty forecast?',
                'answer_4' => 'The current difficulty and its projected change for :name are available on this page. The forecast is calculated using the current block generation rate and other network data for :short.',
                'question_5' => 'How is :short network difficulty calculated?',
                'answer_5' => 'The difficulty calculation algorithm is defined by the rules of each cryptocurrency protocol. In the :short network, the difficulty is adjusted based on the actual block generation time during the previous adjustment period to keep block production close to the target rate.',
                'question_6' => 'What is the relationship between :short difficulty and hashrate?',
                'answer_6' => 'Hashrate represents the total computational power of miners on the network, while difficulty determines how difficult it is to find a new block. When hashrate increases, blocks may be found faster than the target rate, so the protocol will typically increase difficulty at the next adjustment.',
                'question_7' => 'How does difficulty affect :short mining profitability?',
                'answer_7' => 'All other conditions being equal, an increase in difficulty reduces expected mining profitability because each miner accounts for a smaller share of the network\'s total computational work. A decrease in difficulty generally has the opposite effect.',
                'question_8' => 'When is the next :short difficulty adjustment?',
                'answer_8' => 'The timing of the next difficulty adjustment depends on the number of remaining blocks and the current block generation rate. This page shows the number of blocks remaining until the adjustment and the estimated time until :short difficulty changes.',
                'question_9' => 'Why does :short network difficulty increase or decrease?',
                'answer_9' => 'The main reason for a difficulty change is a difference between the actual block generation rate and the protocol\'s target rate. If blocks are found faster than the target time, difficulty usually increases. If they are found more slowly, difficulty decreases.',
                'question_10' => 'Where can I see the history of :short difficulty changes?',
                'answer_10' => 'The history of :name difficulty changes is available on this page in the table and chart. It allows you to compare the current difficulty with previous values and see how the network difficulty has changed over time.',
            ],
            "hashrate" => [
                "question_1" => "What does the current :name hashrate indicate?",
                "answer_1" => " =>short hashrate is the total computational power of all miners in the :name network. It measures the number of hash operations that the equipment performs per second to ensure blockchain security.",
                "question_2" => "Why does the :short hashrate graph constantly change?",
                "answer_2" => "The :name metric fluctuates due to new devices joining, unprofitable capacities being disconnected, or miners migrating between pools. This volatility on the historical graph reflects network competition.",
                "question_3" => "How does high computational power affect :name?",
                "answer_3" => "The higher the :short hashrate, the more difficult and expensive it is to conduct a 51% attack. An increase in this metric usually indicates miners' trust in :name and enhances the network's overall resistance to hacking.",
                "question_4" => "Where can I find the daily hashrate change history for :short?",
                "answer_4" => "This page provides a detailed chart and table of :name hashrate history. You can track changes by day, week, or month to assess the state of the :short network."
            ]
        ]
    ],
    'calculator' => [
        'question_1' => 'How is the profitability of :b :m calculated?',
        'answer_1' => 'The calculator estimates the profitability of :b :m based on its hashrate, power consumption, and current network parameters. The calculation also includes the mined coin price, network difficulty, pool fee, electricity cost, and the specified uptime percentage. As a result, you get revenue, expenses, and net mining profit for a day, month, or year.',
        'question_2' => 'Which coin is the most profitable to mine with :b :m?',
        'answer_2' => 'The calculator analyzes all coins available for :b :m on the :a algorithm and calculates their current profitability. The results are sorted by profitability, so the most profitable option at the time of calculation appears at the top of the list. You can also select any coin manually and compare its profitability with other options.',
        'question_3' => 'Which coins can be mined with :b :m?',
        'answer_3' => ':b :m operates on the :a algorithm, so it can mine all coins that support this algorithm. The calculator automatically determines the available options and shows their current profitability, allowing you to select the most profitable coin to mine.',
        'question_4' => 'How is the net profit of :b :m calculated?',
        'answer_4' => 'The net profit of :b :m is calculated based on gross mining revenue minus electricity costs, pool fees, and other expenses included in the settings. When tax calculation is enabled, the calculator also takes into account the applicable tax burden and equipment depreciation.',
        'question_5' => 'How much electricity does :b :m consume?',
        'answer_5' => ':b :m has a rated power consumption of :p W and an energy efficiency of :e. Actual electricity costs depend on how long the equipment operates and your electricity tariff. Enter your electricity cost and uptime percentage in the calculator to estimate expenses for your specific conditions.',
        'question_6' => 'How does the electricity tariff affect the profitability of :b :m?',
        'answer_6' => 'The higher the electricity cost, the higher the operating expenses of :b :m and the lower its net profit. The calculator allows you to specify your own electricity tariff in ₽/kWh and calculate the equipment profitability based on your actual electricity costs.',
        'question_7' => 'How is the payback period of :b :m calculated?',
        'answer_7' => 'The payback period of :b :m is calculated based on the equipment price and its current net mining profit. The calculation uses the current equipment price, including available offers on TrustMining. Therefore, changes in ASIC price, profitability, electricity tariff, or other parameters can affect the payback period.',
        'question_8' => 'Does the calculator take taxes and depreciation for :b :m into account?',
        'answer_8' => 'Yes. You can enable tax calculation and specify the relevant parameters in the additional settings. When calculating the tax burden, the calculator takes equipment depreciation into account, providing a more complete estimate of the net mining profit from :b :m.',
        'question_9' => 'Which firmware is available for :b :m?',
        'answer_9' => 'The calculator shows available firmware options for :b :m along with their relevant parameters. You can compare different firmware versions and evaluate their impact on hashrate, power consumption, energy efficiency, and mining profitability.',
        'question_10' => 'How does firmware affect the profitability of :b :m?',
        'answer_10' => 'Depending on the firmware, the hashrate and power consumption of :b :m may change, which can also affect its energy efficiency and net profit. The calculator allows you to compare available firmware options and estimate how the profitability of the equipment changes with each one.',
        'question_11' => 'How does a change in network difficulty affect the profitability of :b :m?',
        'answer_11' => 'All other things being equal, an increase in network difficulty reduces the profitability of :b :m because the equipment receives a smaller share of the network reward at the same hashrate. A decrease in difficulty has the opposite effect. The calculator uses current network parameters at the time of calculation, so the result can change as the difficulty and hashrate of the :a network change.',
        'question_12' => 'Does the calculator take the mining pool fee into account?',
        'answer_12' => 'Yes. You can specify the mining pool fee in the calculator’s additional settings. It is included when calculating the net income from :b :m, so the final profit will be lower than the gross mining revenue after the fee is deducted.',
        'question_13' => 'Why can the profitability of :b :m change after the calculation?',
        'answer_13' => 'The profitability of :b :m is not a fixed value. It depends on the price of the mined coin, network difficulty and hashrate, block reward, pool fee, and other parameters. When these factors change, the actual income may differ from a previous calculation. TrustMining uses current data available at the time the calculation is performed.',
        'question_14' => 'Which ASIC should I choose instead of :b :m?',
        'answer_14' => 'Choosing an alternative ASIC depends on your budget, the :a algorithm, power consumption, current profitability, and payback period. On TrustMining, you can compare :b :m with other models operating on the :a algorithm and choose equipment with higher profitability, better energy efficiency, or a shorter payback period.',
    ],
    'profitable' => [
        'question_1' => 'How to use the most profitable ASIC miners calculator?',
        'answer_1' => 'Select the currency (RUB or USDT) and specify your electricity rate (from 0 to 20 RUB per kWh). The rating will automatically recalculate the net profit for 50 models and display the top 15 most profitable devices. This allows you to instantly see which ASICs remain profitable specifically at your electricity cost.',
        'question_2' => 'How is the net profit of mining equipment calculated?',
        'answer_2' => 'Profit is calculated using the formula: (Gross income from mined coins) minus (ASIC power consumption * Electricity rate). We take into account the current network difficulty and the latest exchange rates. The table shows the result after deducting electricity costs.',
        'question_3' => 'What is the most profitable mining equipment in :y?',
        'answer_3' => 'In :y, the leadership is held by models with the best energy efficiency. With a low electricity rate, high-power SHA-256 devices lead the way; however, when the plug cost exceeds 5-7 rubles, specialized ASIC miners for alternative algorithms with higher yield per watt move to the top spots.',
        'question_4' => 'Why does the list of profitable models change when the rate is updated?',
        'answer_4' => 'Electricity is the main variable cost. High-consumption models may be leaders with "free" electricity but instantly become unprofitable at a rate of 10-15 rubles. Our tool rearranges the rating to show you only those devices that generate a real surplus based on your input data.',
        'question_5' => 'How accurately is the income displayed in RUB and USDT?',
        'answer_5' => 'Data is updated in real-time. When USDT is selected, the calculation is tied to the exchange rate, and when RUB is selected, the current quotation is used, allowing for an accurate estimation of fiat profitability and equipment payback periods in the local currency.',
    ],
    'warranty' => [
        'question_1' => 'Where can I find the serial number (S/N) on my miner?',
        'answer_1' => 'The serial number is usually located on a white sticker on the device chassis or the control board. You can also find the S/N remotely via the miner web interface under the "Status" or "System Information" section. It consists of a combination of digits and Latin letters.',
        'question_2' => 'Why does the warranty status on the manufacturer website differ from my purchase date?',
        'answer_2' => 'The manufacturer warranty period typically begins from the date the equipment is shipped from the factory warehouse in China, not from the date of retail sale. If your ASIC was purchased from a reseller, the actual remaining warranty may be less than the stated 6 or 12 months.',
        'question_3' => 'What should I do if the warranty on my ASIC miner has already expired?',
        'answer_3' => 'If the check shows an "Out of Warranty" status, you can still contact specialized service centers. Post-warranty repairs are performed on a paid basis. We recommend using only original spare parts to maintain a stable hashrate and prevent hardware overheating.',
        'question_4' => 'Is the warranty voided by overclocking the miner or using custom firmware?',
        'answer_4' => 'Yes, most manufacturers (Bitmain, MicroBT) will void the warranty if they detect the use of third-party software, signs of overheating due to overclocking, or operation in improper conditions (high humidity, dust). The warranty is also voided if the factory seals are damaged.',
    ],
    'asic' => [
        'question_1' => 'How do I properly connect the :b :m and start mining?',
        'answer_1_cooling' => [
            'Passive' => 'a passive heatsink. Models with <b>passive cooling</b> do not require any fans or pumps; heat dissipation relies entirely on a heavy-duty heatsink and natural convection. These devices are ideal for residential use due to zero noise output, and they typically run on a standard compact PSU or a Type-C cable.',
            'Air' => 'fans and airflow. <b>Air cooling</b> setups require high-volume ventilation and heavy-duty power cables rated at least 2.5 mm².',
            'Hydro' => 'a water system. <b>Hydro models</b> demand an external water-loop distribution block or a dry cooling tower.',
            'Immersion' => 'immersion fluid. <b>Immersion models</b> can only be operated inside a specialized dielectric fluid tank (bath).',
        ],
        'answer_1' => 'The :b :m features cooling based on :cooling. To initiate mining, plug in the LAN cable, scan your local network for the miner\'s IP using an ASIC Tool, open the web dashboard, and enter your target pool stratum addresses.',

        'question_2' => 'How much does the :coin :b :m miner cost and where to buy it?',
        'answer_2' => 'Currently, the best available price for the :b :m :h ASIC miner on our platform is <b>:price rubles</b>. This listing is provided by <b>:company</b>. You can review all current listings, evaluate supplier credibility using our Trust Factor badge, and proceed with a secure deal inside our catalog.',

        'question_3' => ':h :mes — how much is it in other metrics and how to convert :b :m hashrate?',
        'units' => [
            'names' => [
                'h'   => 'hash/s',
                'sol' => 'sol/s',
                'g'   => 'graph/s',
                'c'   => 'cuckoo/s',
                'k'   => 'key/s',
            ],
            'prefixes' => [
                ''  => '',
                'k' => 'kilo',
                'M' => 'Mega',
                'G' => 'Giga',
                'T' => 'Tera',
                'P' => 'Peta',
                'E' => 'Exa',
            ]
        ],
        'answer_3' => 'Upon conversion, the computing power of :h is equivalent to :converted_text. Depending on the coin algorithm, the baseline operational output denomination might be displayed in different network standards. To quickly convert any hashrate, solution, or graph volumes without manual calculations, use our dedicated <a target="_blank" href="' . route('hashrate-converter') . '" class="inline text-indigo-500 hover:text-indigo-600">hashrate converter tool on the TrustMining website</a>.',

        'question_4' => 'How long does it take for the :b :m :h to mine 1 Bitcoin?',
        'answer_4' => 'Given the current network difficulty of <b>:d</b> and a block reward of <b>:r</b> BTC, a single :b :m :h will take approximately <b>:btc_time</b> to successfully secure 1 full Bitcoin. The device yields roughly <b>:p BTC</b> or <b>:ps satoshi</b> per day on average.',

        'question_5' => 'How much bandwidth data does the :b :m consume and what network cable/router is required for ASICs?',
        'answer_5' => 'The :m rig is exceptionally data-efficient, utilizing only about <b>50 to 150 MB of network data per month</b> per machine, as it only sends small textual cryptographic shares (work updates) to the pool server. The core requirement is connection stability and minimal network latency rather than raw speed (Ping to the pool under 50-80 ms). ASICs must be connected exclusively via a **wired LAN cable** (Ethernet).',

        'question_6' => 'What is the average operational lifespan of the :b :m miner?',
        'answer_6' => 'If adequate cooling is maintained (ASIC chips under 75-80°C), dust is cleared regularly (every 6 months), and grid voltage stays stable, the :m can operate reliably for **3 to 5 years**. The most common components requiring eventual routine replacement are cooling fans.',
    ],
    'converter' => [
        'question_1' => 'How do I convert hashrate from TH/s to GH/s or MH/s?',
        'answer_1' => 'Computing power conversion in crypto mining follows the standard metric system, where each prefix tier multiplies or divides the base value by 1000. For instance, <b>1 TH/s (Terahash)</b> equals 1,000 GH/s (Gigahashes), 1,000,000 MH/s (Megahashes), or 1,000,000,000,000 H/s (raw hashes). Our online converter calculates these shifts automatically.',

        'question_2' => 'What is the difference between H/s, Sol/s, and Graphs/s?',
        'answer_2' => 'These are fundamentally distinct computing performance units linked to specific cryptographic setups: <br>• <b>H/s (Hashes/s)</b> is utilized in classic PoW mining grids (Bitcoin, Litecoin).<br>• <b>Sol/s (Solutions/s)</b> measures operational solutions found per second on Equihash engines (Zcash).<br>• <b>Graphs/s (or G/s)</b> calculates graph generation velocity on Cuckoo Cycle frameworks (Grin coin).<br>They cannot be directly compared or added up, as they execute completely different math workloads.',

        'question_3' => 'What do the C/s (Cuckoos) and K/s (Keys) units represent?',
        'answer_3' => 'These metrics are applied to niche or hardware-specific consensus protocols. <b>K/s (Keys per second)</b> tracks structural encryption key evaluation speeds (e.g., CryptoNight derivatives). <b>C/s (Cuckoos or Chirps)</b> captures computing cycle runtimes for target Cuckoo architectures. Use our main calculator dropdown to easily denominate these configurations.',

        'question_4' => 'How does hashrate affect mining profitability and coin generation speed?',
        'answer_4' => 'Hashrate is the raw velocity at which your mining hardware computes cryptographic puzzles. The higher this metric, the more valid shares your machine transmits to the pool per second, securing you a larger slice of the network block reward. If the network difficulty spikes, the amount of coins mined at the exact same hashrate will drop, which is why tracking active hardware performance is vital.',
    ]
];
