<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('contact_types')->insert([
            [
                'name' => 'phone',
                'href' => 'tel:',
            ], [
                'name' => 'email',
                'href' => 'mailto:',
            ], [
                'name' => 'whatsapp',
                'href' => 'https://wa.me/',
            ], [
                'name' => 'telegram',
                'href' => 'https://t.me/',
            ]
        ]);
    }
}
