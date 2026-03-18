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
    ]
];
