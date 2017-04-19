<?php

use App\Models\Religion;
use App\Models\ReligionLocale;
use App\Services\Web\LocaleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localeList = LocaleService::getAllLocale();
        $localeId = $localeList[App::getLocale()]['id'];

        $data = [
            [
                'place_holder' => 'Buddhism',
            ],
            [
                'place_holder' => 'Catholics',
            ],
            [
                'place_holder' => 'Christianity',
            ],
            [
                'place_holder' => 'Confucianism',
            ],
            [
                'place_holder' => 'Hindu',
            ],
            [
                'place_holder' => 'Islam',
            ],
            [
                'place_holder' => 'Other',
            ],
            [
                'place_holder' => 'Taoism',
            ]
        ];

        foreach ($data as $religionRawData) {
            $religion = Religion::create($religionRawData);

            $localeRawData = [
                'locale_id' => $localeId,
                'religion_id' => $religion->id,
                'name' => $religion->place_holder,
            ];

            $religionLocale = ReligionLocale::create($localeRawData);
        }
    }
}
