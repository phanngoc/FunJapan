<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'iso_code' => 'id',
                'name' => 'Indonesian',
            ],
            [
                'iso_code' => 'th',
                'name' => 'Thai',
            ],
            [
                'iso_code' => 'ms',
                'name' => 'Malaysia',
            ],
            [
                'iso_code' => 'tw',
                'name' => 'Taiwan',
            ],
        ];

        Locale::insert($data);
    }
}
