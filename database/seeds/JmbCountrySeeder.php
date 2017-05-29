<?php

use Illuminate\Database\Seeder;
use App\Models\JmbCountry;
use Carbon\Carbon;

class JmbCountrySeeder extends Seeder
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
            $handle = fopen(__DIR__ . '/data/jmb_country.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['id'] = $row[0];
                        $input['name'] = $row[1];
                        $input['code'] = $row[2];
                        $input['available'] = $row[3];
                        $input['number_identity'] = empty($row[4]) ? null : $row[4];
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();

                        $country[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($country) {
                JmbCountry::insert($country);
            }

            DB::commit();
            echo "Seeding Jmb Country data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Jmb Country data has fail.\n";
            DB::rollback();
        }
    }
}
