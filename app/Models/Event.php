<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class Event extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'location', 'category', 'start_date', 'end_date', 'status'])
            ->setDescriptionForEvent(fn(string $eventName) => "Event telah {$eventName}")
            ->useLogName('event')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->name, // menggunakan name karena itu adalah field judul di tabel events
            'description' => $this->description,
            'type' => $this->type,
            'kategori' => $this->kategori,
            'penyelenggara' => $this->penyelenggara
        ];
    }

    public function shouldBeSearchable()
    {
        return true; // memastikan semua event dapat dicari
    }

    protected $table = 'events';
    protected $appends = ['image_url'];

    protected $fillable = [
        'name',
        'start_date',
        'jam_mulai',
        'end_date',
        'jam_selesai',
        'status',
        'description',
        'tempat',
        'type',
        'image',
        'kategori',
        'penyelenggara',
        'visit_count',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/placeholder.jpg'); // Pastikan ada gambar placeholder
        }
        
        // Jika image adalah URL lengkap
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Jika image disimpan di storage
        return Storage::disk('public')->exists($this->image)
            ? asset(Storage::url($this->image))
            : asset('images/placeholder.jpg');
    }

    public function pengunjung()
    {
        return $this->hasMany(Pengunjung::class);
    }
    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites', 'events_id', 'user_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }

    public function berita()
    {
        return $this->hasOne(Berita::class);
    }
    public function banners()
    {
        return $this->hasMany(EventBanner::class);
    }

    // Accessor untuk memastikan format waktu yang konsisten
    public function getWaktuMulaiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getWaktuSelesaiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    // Mutator untuk memastikan penyimpanan yang benar
    public function setWaktuMulaiAttribute($value)
    {
        $this->attributes['waktu_mulai'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function setWaktuSelesaiAttribute($value)
    {
        $this->attributes['waktu_selesai'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    /**
     * Get the banner image URL for the event.
     *
     * @return string
     */
    public function getBannerUrlAttribute()
    {
        if ($this->banner) {
            // Jika banner ada, gunakan itu
            if (filter_var($this->banner, FILTER_VALIDATE_URL)) {
                return $this->banner;
            }
            
            return Storage::disk('public')->exists($this->banner)
                ? asset(Storage::url($this->banner))
                : $this->getImageUrlAttribute(); // Fallback ke image jika banner tidak ditemukan
        }
        
        // Jika banner tidak ada, gunakan image sebagai fallback
        return $this->getImageUrlAttribute();
    }

}
