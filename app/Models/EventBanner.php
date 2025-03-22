<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventBanner extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $table = 'event_banners';
    
    protected $fillable = [
        'image',
        'judul',
        'deskripsi',
        'is_active',
        'urutan'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['event_id', 'image', 'order'])
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => 'Banner event baru telah ditambahkan',
                    'updated' => 'Banner event telah diperbarui',
                    'deleted' => 'Banner event telah dihapus',
                    default => "Banner event telah {$eventName}"
                };
            })
            ->useLogName('event_banner')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the banner image URL.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        
        Log::warning("EventBanner: Image not found for banner ID={$this->id}, path={$this->image}");
        return asset('images/placeholder-banner.jpg');
    }
    
    /**
     * Check if the image file exists.
     *
     * @return bool
     */
    public function imageExists()
    {
        if (empty($this->image)) {
            Log::warning("EventBanner: Empty image path for banner ID={$this->id}");
            return false;
        }
        
        $exists = Storage::disk('public')->exists($this->image);
        if (!$exists) {
            Log::warning("EventBanner: File not found for banner ID={$this->id}, path={$this->image}");
        }
        
        return $exists;
    }
}
