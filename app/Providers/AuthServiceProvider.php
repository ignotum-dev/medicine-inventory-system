<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
<<<<<<< HEAD
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;
=======
// use App\Policies\RolePolicy;
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Purchase::class => PurchasePolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
