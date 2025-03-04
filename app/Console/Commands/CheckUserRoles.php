<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CheckUserRoles extends Command
{
    protected $signature = 'users:check-roles';
    protected $description = 'Check users and their roles';

    public function handle()
    {
        $this->info('Checking roles...');
        $roles = Role::all();
        $this->info('Available roles: ' . $roles->pluck('name')->implode(', '));

        $this->info("\nChecking users...");
        $users = User::withCount('roles')->get();
        foreach ($users as $user) {
            $this->info("{$user->id} - {$user->name} - Role count: {$user->roles_count}");
            if ($user->roles_count > 0) {
                $this->info("Roles: " . $user->roles->pluck('name')->implode(', '));
            } else {
                $this->warn("No roles assigned");
            }
            $this->line('------------------------');
        }
    }
}
