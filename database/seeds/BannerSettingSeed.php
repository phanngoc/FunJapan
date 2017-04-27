<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\BannerSetting;

class BannerSettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = Locale::all();

        $importData = [];

        foreach ($locales as $locale) {
            $data = [
                [
                    'order' => 1,
                    'locale_id' => $locale->id,
                ],
                [
                    'order' => 2,
                    'locale_id' => $locale->id,
                ],
                [
                    'order' => 3,
                    'locale_id' => $locale->id,
                ],
            ];

            $importData = array_merge($importData, $data);
        }

        BannerSetting::insert($importData);
    }
}
