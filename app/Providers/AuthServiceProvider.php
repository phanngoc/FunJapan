<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('permission', function ($user, $permissions, $permitAll = false) {
            if (!$user->isAccessAdmin()) {
                return false;
            }

            if (is_array($permissions)) {
                $permit = true;
                foreach ($permissions as $permission) {
                    if (!$permitAll && $user->hasDefinePrivilege($permission)) {
                        return true;
                    }

                    $permit = $permit && $user->hasDefinePrivilege($permission);
                }

                return $permit;
            }

            return $user->hasDefinePrivilege($permissions);
        });
    }
}
