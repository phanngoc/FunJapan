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
                    'photo' => 'assets/images/article/recommended_img_2_1.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 2,
                    'photo' => 'assets/images/article/recommended_img_01.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 3,
                    'photo' => 'assets/images/article/recommended_img_2_2.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 4,
                    'photo' => 'assets/images/article/recommended_img_2_3.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 5,
                    'photo' => 'assets/images/article/recommended_img_2_4.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 6,
                    'photo' => 'assets/images/article/recommended_img_2_5.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 7,
                    'photo' => 'assets/images/article/recommended_img_2_6.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 8,
                    'photo' => 'assets/images/article/recommended_img_2_1.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 9,
                    'photo' => 'assets/images/article/recommended_img_2_2.jpg',
                    'user_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'id' => 10,
                    'photo' => 'assets/images/article/recommended_img_2_3.jpg',
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
