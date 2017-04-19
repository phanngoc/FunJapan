<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryLocale;
use Carbon\Carbon;

class CategorySeeder extends Seeder
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
            $categories = [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 2,
                    'user_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ];

            $categoryLocales = [
                [
                    'locale_id' => 1,
                    'category_id' => 1,
                    'name' => 'How we share the information',
                    'description' => 'How we share the information',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'locale_id' => 2,
                    'category_id' => 1,
                    'name' => 'How we share the information',
                    'description' => 'How we share the information',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'locale_id' => 3,
                    'category_id' => 1,
                    'name' => 'How we share the information',
                    'description' => 'How we share the information',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'locale_id' => 1,
                    'category_id' => 2,
                    'name' => 'Resolving Complaints',
                    'description' => 'Resolving Complaints',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'locale_id' => 2,
                    'category_id' => 2,
                    'name' => 'Resolving Complaints',
                    'description' => 'Resolving Complaints',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'locale_id' => 3,
                    'category_id' => 2,
                    'name' => 'Resolving Complaints',
                    'description' => 'Resolving Complaints',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ];

            Category::insert($categories);
            CategoryLocale::insert($categoryLocales);

            DB::commit();
            echo "Seeding Categories data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Categories data has fail.\n";
            DB::rollback();
        }
    }
}
