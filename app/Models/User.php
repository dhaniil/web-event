<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'nomer', 'kelas', 'jurusan', 'profile_picture'])
            ->setDescriptionForEvent(fn(string $eventName) => "User telah {$eventName}")
            ->useLogName('user')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'nomer',
        'kelas',
        'jurusan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasRole('Super Admin')) {
            return true;
        }
        if ($this->hasAnyRole(['Admin', 'Sekbid'])) {
            return $this->hasAnyPermission([
                'view_admin',
                'view_sekbid',
                'view_event',
                'view_berita',
                'view_ulasan',
                'view_activity_log'
            ]);
        }

        return false;
    }

    public function isSuperadmin(): bool
    {
        return $this->hasRole('Super Admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isSekbid(): bool
    {
        return $this->hasRole('Sekbid');
    }

    public function isPengunjung(): bool
    {
        return $this->hasRole('Pengunjung');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Event yang difavoritkan oleh user
     */
    public function favourites()
    {
        return $this->belongsToMany(Event::class, 'favourites', 'user_id', 'events_id');
    }
    
    /**
     * Sama dengan favourites(), hanya nama metode yang berbeda
     * untuk kejelasan semantik
     */
    public function favouriteEvents()
    {
        return $this->belongsToMany(Event::class, 'favourites', 'user_id', 'events_id');
    }

    public function setPasswordAttribute($value)
    {
        if (str_starts_with($value, '$2y$')) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public static function getStats(): array
    {
        Log::info('Calculating user stats...');
        
        // Get all available roles
        $roles = Role::all();
        Log::info('Available roles: ' . $roles->pluck('name'));
        
        $totalUsers = static::count();
        Log::info('Total users: ' . $totalUsers);
        
        $newUsers = static::where('created_at', '>=', now()->subDays(7))->count();
        
        $roleCounts = [];
        foreach ($roles as $role) {
            $count = static::role($role->name)->count();
            $roleCounts[$role->name] = $count;
            Log::info("{$role->name} count: {$count}");
        }
        
        // Check users without roles
        $noRoleCount = static::whereDoesntHave('roles')->count();
        Log::info('Users without roles: ' . $noRoleCount);
        
        $userIncrease = $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100, 1) : 0;

        return array_merge([
            'total' => $totalUsers,
            'new' => $newUsers,
            'increase' => $userIncrease,
            'no_role' => $noRoleCount
        ], $roleCounts);
    }

    /**
     * Get the user's profile picture URL.
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            if (Storage::disk('public')->exists($this->profile_picture)) {
                return asset('storage/' . $this->profile_picture) . '?v=' . time();
            }
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . substr($this->name, 0, 1) . '&background=5356FF&color=fff&size=150';
    }
}
