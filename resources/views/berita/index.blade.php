@extends('extend.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/eventonly.css') }}" />
    <style>
        /* Perbaikan layout halaman berita */
        .berita-container {
            min-height: calc(100vh - 180px);
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .page-title {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .page-title h1 {
            font-size: 1.8rem;
            color: #333;
        }
        
        .berita-item {
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .berita-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .berita-image {
            height: 220px;
            overflow: hidden;
        }
        
        .berita-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .berita-item:hover .berita-image img {
            transform: scale(1.05);
        }
        
        .berita-content {
            padding: 20px;
        }
        
        .berita-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .berita-meta {
            display: flex;
            align-items: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .berita-date {
            margin-right: 15px;
        }
        
        .berita-excerpt {
            color: #555;
            margin-bottom: 15px;
        }
        
        .berita-link {
            display: inline-block;
            padding: 8px 20px;
            background-color: #4F46E5;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .berita-link:hover {
            background-color: #3c35b5;
            color: white;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
        }
    </style>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('content')
<div class="content-area">
    <div class="berita-container">
        <div class="page-title">
            <h1>Berita Event Terbaru</h1>
        </div>
        
        <div class="row">
            @if(count($beritas) > 0)
                @foreach($beritas as $berita)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="berita-item">
                        <div class="berita-image">
                            <img src="{{ $berita->image_url }}" 
                                 alt="{{ $berita->judul ?? $berita->title }}" 
                                 class="img-fluid">
                        </div>
                        <div class="berita-content">
                            <h2 class="berita-title">{{ $berita->judul }}</h2>
                            <div class="berita-meta">
                                <span class="berita-date"><i class="far fa-calendar-alt me-1"></i> {{ $berita->created_at->format('d M Y') }}</span>
                                <span class="berita-author"><i class="far fa-user me-1"></i> 
                                    {{ $berita->user?->name ?? 'Admin' }}
                                </span>
                            </div>
                            <div class="berita-excerpt">
                                {{ Str::limit($berita->konten, 120) }}
                            </div>
                            <a href="{{ route('berita.show', $berita->id) }}" class="berita-link">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @if(config('app.debug'))
                    <div style="font-size: 10px; color: #999;">
                        Debug: 
                        image = {{ $berita->image ?? 'NULL' }}, 
                        gambar = {{ $berita->gambar ?? 'NULL' }}, 
                        Accessor = {{ $berita->image_url }}
                    </div>
                @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="far fa-newspaper" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                        <h3 class="empty-state-title">Belum Ada Berita</h3>
                        <p class="empty-state-description">Berita terbaru akan muncul di sini ketika tersedia</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d",
            defaultDate: "{{ request('tanggal') }}",
            allowInput: false
        });
    });
</script>
