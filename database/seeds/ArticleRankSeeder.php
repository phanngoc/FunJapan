<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\ArticleRank;

class ArticleRankSeeder extends Seeder
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
            foreach(config('article.rank') as $rank) {
                $data = [
                    [
                        'rank' => $rank,
                        'locale_id' => $locale->id,
                    ],
                ];

                $importData = array_merge($importData, $data);
            }
        }

        ArticleRank::insert($importData);
    }
}
