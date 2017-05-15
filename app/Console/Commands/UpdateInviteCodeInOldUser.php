<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateInviteCodeInOldUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update_invite_code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNull('invite_code')->get();

        try {
            DB::beginTransaction();

            foreach ($users as $user) {
                $user->timestamps = false;
                $user->invite_code = uniqid(rand(), false);
                $user->save();
            }

            DB::commit();
            $this->alert('Update successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Some thing went wrong');
        }
    }
}
