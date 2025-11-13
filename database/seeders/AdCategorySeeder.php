<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ad_categories')->insert([
            [
                'name' => 'miners',
                'title' => 'Купить оборудование для майнинга, приобрести ASIC майнеры по лучшим ценам',
                'description' => 'Объявления о продаже оборудования для майнинга по самой лучшей цене у проверенных компаний с доставкой по РФ. Цены, характеристики, расчет доходности, реальные отзывы, прошивки, фото. Каталог моделей.',
                'header' => 'Miners'
            ], [
                'name' => 'legals',
                'title' => 'Юридические услуги в сфере майнинга',
                'description' => 'Нанять юриста или адвоката с лучшим рейтингом, специализирующегося в сфере майнинга',
                'header' => 'Legals'
            ], [
                'name' => 'containers',
                'title' => 'Купить ISO контейнер для майнинга',
                'description' => 'Производители и дилеры контейнеров для майнинга с подготовленной вентиляцией и проводкой',
                'header' => 'Containers'
            ], [
                'name' => 'noiseboxes',
                'title' => 'Шумоизоляция для ASIC майнеров, шумобоксы',
                'description' => 'Купить шумобокс для майнингового оборудования с доставкой по РФ. Цены, размеры, характеристики, отзывы',
                'header' => 'Noiseboxes'
            ], [
                'name' => 'cryptoboilers',
                'title' => 'Криптокотлы, реализация тепла от майнинга',
                'description' => 'Обогрев дома с помощью майнинга, использование выделяемого тепла от ASIC майнеров',
                'header' => 'Cryptoboilers'
            ], [
                'name' => 'water_cooling_plates',
                'title' => 'Водоблоки: эффективное охлаждение ASIC майнера',
                'description' => 'Водяное охлаждение. Обогрев дома с помощью майнинга, использование выделяемого тепла от ASIC майнеров',
                'header' => 'Water cooling plates'
            ]
        ]);
    }
}
