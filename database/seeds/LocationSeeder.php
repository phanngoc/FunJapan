<?php

use App\Services\Web\LocaleService;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\App;

class LocationSeeder extends Seeder
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
                'name' => 'Jabodetabek',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Bandung',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Surabaya',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Medan',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Jawa Barat, Banten',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Jawa Tengah, Yogyakarta',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Jawa Timur',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Sumatra',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Kalimantan',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Sulawesi',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Bali, NTB, NTT',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Maluku, Papua',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'OtherCountry',
                'locale_id' => $localeId,
            ],
            [
                'name' => 'Japan',
                'locale_id' => $localeId,
            ],
        ];

        Location::insert($data);
    }
}
