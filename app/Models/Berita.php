<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Berita extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content', 'status', 'published_at', 'featured_image'])
            ->setDescriptionForEvent(fn(string $eventName) => "Berita telah {$eventName}")
            ->useLogName('berita')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'berita';

    protected $fillable = [
        'title',
        'judul',
        'slug',
        'excerpt',
        'ringkasan',
        'content',
        'konten',
        'image',
        'gambar',
        'category',
        'kategori',
        'published_at',
        'tanggal_terbit',
        'status',
        'author_id',
        'user_id',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category' => $this->category
        ];
    }

    public function shouldBeSearchable()
    {
        return true;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        // Cek field image dan gambar
        $imageField = $this->image ?? $this->gambar ?? null;
        
        if (!$imageField) {
            return asset('images/placeholder.jpg'); // Gambar placeholder default
        }
        
        // Cek apakah gambar adalah URL lengkap
        if (filter_var($imageField, FILTER_VALIDATE_URL)) {
            return $imageField;
        }
        
        // Cek apakah file exists dan return URL yang benar
        return Storage::disk('public')->exists($imageField)
            ? asset('storage/' . $imageField)
            : asset('images/placeholder.jpg');
    }
}
