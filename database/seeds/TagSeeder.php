<?php

use App\Models\Tag;
use App\Models\Article;
use App\Models\ArticleTag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'id' => 1,
                'name' => 'Japanese',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'festival',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Tag::insert($tags);

        $articles = Article::all();

        if ($articles->count()) {
            foreach ($articles as $article) {
                $articleTag = [
                    [
                        'tag_id' => 1,
                        'article_id' => $article->id,
                        'article_locale_id' => $article->articleLocales->first()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                    [
                        'tag_id' => 2,
                        'article_id' => $article->articleLocales->first()->id,
                        'article_locale_id' => $article->articleLocales->first()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                ];

                ArticleTag::insert($articleTag);
            }
        }
    }
}
