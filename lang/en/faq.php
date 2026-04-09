<?php

return [
    'metrics' => [
        'network' => [
            "difficulty" => [
                "question_1" => "What is the network difficulty of :name (:short)?",
                "answer_1" => " =>name difficulty is a parameter that determines how hard it is to perform mathematical calculations to find a new block in the :short blockchain. It is automatically adjusted to maintain stable block generation time when the total network hashrate changes. You can also find more detailed information in our article.",
                "question_2" => "How often is the :short difficulty recalculated?",
                "answer_2" => " =>name algorithm regularly updates the difficulty level. The recalculation period depends on the specific coin protocol and aims to prevent miners from mining blocks either too fast or too slow.",
                "question_3" => "What impact does the increase in :name difficulty have?",
                "answer_3" => "An increase in :short difficulty means that more computational power is required to mine the same amount of coins. This usually reduces mining profitability for older equipment but makes the network more secure against attacks.",
                "question_4" => "Where can I see the current difficulty forecast for :short?",
                "answer_4" => "The current chart and difficulty forecast for :name are available on this page. The data is updated in real-time based on the current block generation speed in the :short network."
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
    "calculator" => [
        "question_1" => "How does the calculator select the most profitable coins for :m?",
        "answer_1" => "Unlike regular services, our calculator automatically analyzes all available coins on the :a algorithm. The most profitable asset group is displayed at the top of the list for the current moment, but you can manually select any other coin to compare mining profitability and prospects for :b :m.",
        "question_2" => "What formula is used to calculate net mining profit?",
        "answer_2" => "The calculation is based on the formula: (Block Reward * Hashrate Share) - (Power Consumption :p W * Electricity Price per kWh * Operating Time). We also take into account pool fees and uptime percentage to provide the most realistic net profit forecast.",
        "question_3" => "Why do I need to specify uptime percentage and device count?",
        "answer_3" => "If you use a farm with multiple :b :m units or your equipment doesn't operate 24/7 (e.g., due to overheating or night tariff), specify the device count and uptime percentage in additional settings. This helps adjust the final hashrate and electricity costs.",
        "question_4" => "What is the energy efficiency of the :b :m :v model?",
        "answer_4" => "This model has an energy efficiency rating of :e. Consuming :p watts, the device delivers the declared hashrate :v on the :a algorithm.",
        "question_5" => "How accurate is the profitability forecast for :m today?",
        "answer_5" => "The data is updated in real-time, taking into account current network difficulty and market value of selected coins. However, keep in mind that :b :m profitability may change tomorrow due to sudden price fluctuations or changes in the :a algorithm hashrate.",
        "question_6" => "What factors affect the payback period for :b :m?",
        "answer_6" => "The payback period depends on your electricity price, chosen pool fees, and market price of mined coins. Use our calculator to find the most profitable coin/algorithm pair for :b :m :v and reduce investment return time."
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
];
