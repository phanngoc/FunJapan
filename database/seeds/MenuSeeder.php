<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Carbon\Carbon;

class MenuSeeder extends Seeder
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
            $handle = fopen(__DIR__ . '/data/menu.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['id'] = $row[0];
                        $input['description'] = $row[1];
                        $input['parent_id'] = empty($row[2]) ? null : $row[2];
                        $input['icon'] = $row[3];
                        $input['link'] = $row[4];
                        $input['type'] = $row[5];
                        $input['name'] = $row[6];
                        $input['order'] = $row[7];
                        $input['locale_id'] = $row[8];
                        $input['icon_class'] = $row[9];
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();

                        $menu[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($menu) {
                Menu::insert($menu);
            }

            DB::commit();
            echo "Seeding Menu data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Menu data has fail.\n";
            DB::rollback();
        }
    }
}
