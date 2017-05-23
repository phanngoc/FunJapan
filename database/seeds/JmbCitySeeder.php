<?php

use Illuminate\Database\Seeder;
use App\Models\JmbCity;
use Carbon\Carbon;

class JmbCitySeeder extends Seeder
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
            $handle = fopen(__DIR__ . '/data/jmb_city.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['id'] = $row[0];
                        $input['name'] = $row[1];
                        $input['ssz'] = $row[2];
                        $input['ssu'] = $row[3];
                        $input['jmb_country_id'] = $row[4];
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();

                        $city[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($city) {
                JmbCity::insert($city);
            }

            DB::commit();
            echo "Seeding Jmb City data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Jmb City data has fail.\n";
            DB::rollback();
            dd($e);
        }
    }
}
