<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Define a gate for admin access
        Gate::define('admin-access', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
