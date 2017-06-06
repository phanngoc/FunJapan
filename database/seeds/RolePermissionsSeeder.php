<?php

use Illuminate\Database\Seeder;
use App\Models\RolePermission;
use Carbon\Carbon;

class RolePermissionsSeeder extends Seeder
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
            $handle = fopen(__DIR__ . '/data/role_permissions.csv', 'r');

            if ($handle !== false) {
                $header = null;

                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $input = array_combine($header, $row);
                        $input['role_id'] = $row[0];
                        $input['permission'] = $row[1];
                        $input['created_at'] = Carbon::now();
                        $input['updated_at'] = Carbon::now();

                        $rolePermissions[] = $input;
                    }
                }

                fclose($handle);
            }

            if ($rolePermissions) {
                RolePermission::insert($rolePermissions);
            }

            DB::commit();
            echo "Seeding Role Permissions data has done.\n";
        } catch (Exception $e) {
            echo "Seeding Role Permissions data has fail.\n";
            DB::rollback();
        }
    }
}
