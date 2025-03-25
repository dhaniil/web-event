@extends('extend.main')

@section('styles')
<style>
    /* Styling untuk halaman hasil pencarian */
    .search-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }
    
    .search-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .search-query {
        color: #3c5cff;
        font-weight: 500;
    }
    
    .search-indicator {
        width: 50px;
        height: 4px;
        background-color: #3c5cff;
        margin: 1rem auto;
    }
    
    .search-form-container {
        max-width: 600px;
        margin: 0 auto 2rem;
    }
    
    .search-form input {
        border-radius: 8px 0 0 8px;
        height: 46px;
        border: 1px solid #ddd;
    }
    
    .search-form button {
        border-radius: 0 8px 8px 0;
        background-color: #3c5cff;
        color: white;
        border: none;
        height: 46px;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-left: 15px;
        border-left: 4px solid #3c5cff;
    }
    
    .result-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-image {
        height: 180px;
        overflow: hidden;
        position: relative;
    }
    
    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .result-card:hover .card-image img {
        transform: scale(1.05);
    }
    
    .card-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
    }
    
    .event-badge {
        background-color: #3c5cff;
        color: white;
    }
    
    .news-badge {
        background-color: #6c757d;
        color: white;
    }
    
    .card-content {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #333;
    }
    
    .card-text {
        color: #6c757d;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    
    .card-link {
        color: #3c5cff;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .card-link:hover {
        text-decoration: underline;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="search-header text-center">
    <div class="container">
        <h1 class="search-title">Hasil Pencarian</h1>
        <p class="lead">untuk kata kunci <span class="search-query">"{{ $query }}"</span></p>
        <div class="search-indicator"></div>
        
        <div class="search-form-container">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" value="{{ $query }}" placeholder="Cari event atau berita...">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container py-4">
    @if($events->isEmpty() && $berita->isEmpty())
        <div class="empty-state">
            <i class="fas fa-search empty-icon"></i>
            <h3 class="mb-3">Tidak Ada Hasil Ditemukan</h3>
            <p class="text-muted mb-4">Coba gunakan kata kunci yang berbeda atau periksa ejaan</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('events.eventonly') }}" class="btn btn-outline-primary">Lihat Semua Event</a>
                <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Lihat Semua Berita</a>
            </div>
        </div>
    @else
        @if(!$events->isEmpty())
            <div class="mb-5">
                <h2 class="section-title">Event Terkait</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($events as $event)
                    <div class="col">
                        <div class="result-card">
                            <div class="card-image">
                                <img src="{{ $event->image_url ?? asset('storage/' . $event->image) }}" alt="{{ $event->name }}">
                                <span class="card-badge event-badge">{{ $event->kategori ?? 'Event' }}</span>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">{{ $event->name }}</h3>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}</p>
                                <a href="{{ route('events.show', $event->slug) }}" class="card-link">
                                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($events->hasPages())
                    <div class="pagination-container">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        @endif
        
        @if(!$berita->isEmpty())
            <div class="mb-5">
                <h2 class="section-title">Berita Terkait</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($berita as $item)
                    <div class="col">
                        <div class="result-card">
                            <div class="card-image">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                <span class="card-badge news-badge">Berita</span>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">{{ $item->title }}</h3>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($item->excerpt), 100) }}</p>
                                <a href="{{ route('berita.show', $item->slug) }}" class="card-link">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($berita->hasPages())
                    <div class="pagination-container">
                        {{ $berita->links() }}
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>
@endsection
