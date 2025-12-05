<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ForumSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('forum_subcategories')->insert([
            ['name' => 'Regulation of cryptocurrencies', 'forum_category_id' => 1],
            ['name' => 'Events and summits', 'forum_category_id' => 1],
            ['name' => 'Electricity prices', 'forum_category_id' => 1],
            ['name' => 'Investments and funds', 'forum_category_id' => 1],
            ['name' => 'Ecology', 'forum_category_id' => 1],
            ['name' => 'Large transactions', 'forum_category_id' => 1],
            ['name' => 'Cryptonetwork and blockchain', 'forum_category_id' => 2],
            ['name' => 'Network difficulty and halving', 'forum_category_id' => 2],
            ['name' => 'Exchange rate', 'forum_category_id' => 2],
            ['name' => 'Forks and coin listings', 'forum_category_id' => 2],
            ['name' => 'Models', 'forum_category_id' => 3],
            ['name' => 'Prices', 'forum_category_id' => 3],
            ['name' => 'Setting up', 'forum_category_id' => 3],
            ['name' => 'Modes and firmware', 'forum_category_id' => 3],
            ['name' => 'Errors', 'forum_category_id' => 3],
            ['name' => 'Consumables and accessories', 'forum_category_id' => 3],
            ['name' => 'Pools', 'forum_category_id' => 4],
            ['name' => 'Profitability and payback period', 'forum_category_id' => 4],
            ['name' => 'Cloud mining', 'forum_category_id' => 4],
            ['name' => 'Mining software', 'forum_category_id' => 4],
            ['name' => 'General questions', 'forum_category_id' => 4],
            ['name' => 'Payment systems', 'forum_category_id' => 5],
            ['name' => 'Alternative sources of electricity', 'forum_category_id' => 5],
            ['name' => 'Crypto exchanges and exchangers', 'forum_category_id' => 6],
            ['name' => 'Help and advice', 'forum_category_id' => 6],
            ['name' => 'Predictions', 'forum_category_id' => 6],
            ['name' => 'Scammers', 'forum_category_id' => 7],
            ['name' => 'Legalization', 'forum_category_id' => 7],
            ['name' => 'Electrical wiring', 'forum_category_id' => 8],
            ['name' => 'Noise reduction', 'forum_category_id' => 8],
            ['name' => 'Ventilation', 'forum_category_id' => 8],
            ['name' => 'Cooling', 'forum_category_id' => 8],
            ['name' => 'Realization of heat from mining', 'forum_category_id' => 8],
            ['name' => 'Metaverses and P2E', 'forum_category_id' => 9],
            ['name' => 'NFT', 'forum_category_id' => 9],
            ['name' => 'Airdrops', 'forum_category_id' => 9],
        ]);
    }
}
