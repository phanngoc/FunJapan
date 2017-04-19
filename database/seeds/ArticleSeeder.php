<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleLocale;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            $articles = [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 2,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 3,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 4,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 5,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 6,
                    'user_id' => 1,
                    'category_id' => 1,
                ],
            ];

            Article::insert($articles);

            $articleLocales = [];

            $handle = fopen(__DIR__ . '/data/articleLocales.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();
                        $input['published_at'] = Carbon::now();
                        $articleLocales[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($articleLocales) {
                ArticleLocale::insert($articleLocales);
            }

            DB::commit();
            echo "Seeding ArticleLocales data has done.\n";
        } catch (Exception $e) {
            echo "Seeding ArticleLocales data has fail.\n";
            DB::rollback();
        }
    }
}
