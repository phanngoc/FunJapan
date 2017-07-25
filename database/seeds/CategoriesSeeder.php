<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $handle = fopen(__DIR__ . '/data/categories.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['id'] = $row[0];
                        $input['user_id'] = $row[1];
                        $input['name'] = $row[2];
                        $input['short_name'] = empty($row[3]) ? null : $row[3];
                        $input['icon'] = 'assets/images/top/icon_bus.png';
                        $input['locale_id'] = $row[4];
                        $input['mapping'] = $row[5];
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();

                        $category[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($category) {
                Category::insert($category);
            }

            DB::commit();
            echo "Seeding Category data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Category data has fail.\n";
            DB::rollback();
        }
    }
}
