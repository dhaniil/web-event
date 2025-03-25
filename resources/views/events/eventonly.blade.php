@extends('extend.main')

@section('styles')
<style>
    /* Reset & Base Styles */
    .event-page {
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    /* Header Section */
    .event-header {
        background-color: #fff;
        padding: 30px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }
    
    .page-description {
        color: #6c757d;
        margin-bottom: 20px;
    }
    
    /* Filter Area */
    .filter-area {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .filter-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .filter-title i {
        margin-right: 10px;
        color: #3c5cff;
    }
    
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 14px;
        color: #555;
    }
    
    .filter-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
    
    .filter-control:focus {
        border-color: #3c5cff;
        box-shadow: 0 0 0 3px rgba(60, 92, 255, 0.2);
    }
    
    .filter-actions {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    
    .btn-filter {
        background-color: #3c5cff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
    }
    
    .btn-reset {
        background-color: #f8f9fa;
        color: #555;
        border: 1px solid #ddd;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
    }
    
    /* Category Pills */
    .category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .category-pill {
        background-color: #f8f9fa;
        color: #555;
        border: 1px solid #ddd;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .category-pill:hover, .category-pill.active {
        background-color: #3c5cff;
        color: white;
        border-color: #3c5cff;
    }
    
    /* Event Grid */
    .event-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    
    .event-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .event-card-image {
        height: 180px;
        overflow: hidden;
        position: relative;
    }
    
    .event-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .event-card:hover .event-card-image img {
        transform: scale(1.05);
    }
    
    .event-date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: white;
        color: #333;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .event-category-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 500;
        background-color: #3c5cff;
        color: white;
    }
    
    .event-card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .event-card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #333;
    }
    
    .event-card-description {
        color: #6c757d;
        margin-bottom: 15px;
        flex-grow: 1;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .event-card-meta {
        display: flex;
        align-items: center;
        color: #888;
        font-size: 13px;
        margin-bottom: 15px;
    }
    
    .event-card-meta i {
        margin-right: 5px;
    }
    
    .event-card-meta span {
        margin-right: 15px;
    }
    
    .event-card-link {
        color: #3c5cff;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
    }
    
    .event-card-link:hover {
        text-decoration: underline;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
    }
    
    .empty-icon {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 20px;
    }
    
    /* Pagination */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
        }
        
        .filter-group {
            min-width: 100%;
        }
        
        .filter-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-filter, .btn-reset {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="event-page">
    <!-- Page Header -->
    <div class="event-header">
        <div class="container">
            <h1 class="page-title">Event Stembayo</h1>
            <p class="page-description">Temukan berbagai kegiatan dan acara menarik yang diselenggarakan oleh SMK Negeri 2 Depok Sleman</p>
        </div>
    </div>
    
    <div class="container">
        <!-- Filter Area -->
        <div class="filter-area">
            <h2 class="filter-title"><i class="fas fa-filter"></i> Filter Event</h2>
            
            <form action="{{ route('events.eventonly') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label class="filter-label">Tanggal</label>
                    <input type="date" name="tanggal" class="filter-control" value="{{ request('tanggal') }}">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Kategori</label>
                    <select name="kategori" class="filter-control">
                        <option value="">Semua Kategori</option>
                        <option value="KTYME Islam" {{ request('kategori') == 'KTYME Islam' ? 'selected' : '' }}>KTYME Islam</option>
                        <option value="KTYME Kristiani" {{ request('kategori') == 'KTYME Kristiani' ? 'selected' : '' }}>KTYME Kristiani</option>
                        <option value="KBBP" {{ request('kategori') == 'KBBP' ? 'selected' : '' }}>KBBP</option>
                        <option value="KBPL" {{ request('kategori') == 'KBPL' ? 'selected' : '' }}>KBPL</option>
                        <option value="BPPK" {{ request('kategori') == 'BPPK' ? 'selected' : '' }}>BPPK</option>
                        <option value="KK" {{ request('kategori') == 'KK' ? 'selected' : '' }}>KK</option>
                        <option value="PAKS" {{ request('kategori') == 'PAKS' ? 'selected' : '' }}>PAKS</option>
                        <option value="KJDK" {{ request('kategori') == 'KJDK' ? 'selected' : '' }}>KJDK</option>
                        <option value="PPBN" {{ request('kategori') == 'PPBN' ? 'selected' : '' }}>PPBN</option>
                        <option value="HUMTIK" {{ request('kategori') == 'HUMTIK' ? 'selected' : '' }}>HUMTIK</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-control">
                        <option value="">Semua Status</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Telah Selesai</option>
                    </select>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn-filter"><i class="fas fa-search me-2"></i> Filter</button>
                    <a href="{{ route('events.eventonly') }}" class="btn-reset"><i class="fas fa-redo me-2"></i> Reset</a>
                </div>
            </form>
        </div>
        
        <!-- Category Pills (Optional) -->
        <div class="category-pills">
            <a href="{{ route('events.eventonly') }}" class="category-pill {{ request()->query('kategori') == null ? 'active' : '' }}">Semua</a>
            <a href="{{ route('events.eventonly', ['kategori' => 'KTYME Islam']) }}" class="category-pill {{ request('kategori') == 'KTYME Islam' ? 'active' : '' }}">KTYME Islam</a>
            <a href="{{ route('events.eventonly', ['kategori' => 'KTYME Kristiani']) }}" class="category-pill {{ request('kategori') == 'KTYME Kristiani' ? 'active' : '' }}">KTYME Kristiani</a>
            <a href="{{ route('events.eventonly', ['kategori' => 'KBBP']) }}" class="category-pill {{ request('kategori') == 'KBBP' ? 'active' : '' }}">KBBP</a>
            <a href="{{ route('events.eventonly', ['kategori' => 'HUMTIK']) }}" class="category-pill {{ request('kategori') == 'HUMTIK' ? 'active' : '' }}">HUMTIK</a>
            <!-- Tambahkan kategori lainnya sesuai kebutuhan -->
        </div>
        
        <!-- Event List -->
        @if(isset($events) && count($events) > 0)
            <div class="event-grid">
                @foreach($events as $event)
                <div class="event-card">
                    <!-- Debug info -->
                    @if(config('app.debug'))
                    <div style="font-size: 10px; color: #999;">
                        ID: {{ $event->id }}, 
                        Slug: {{ $event->slug ?? 'NULL' }}, 
                        URL: {{ route('events.show', $event->slug ?? $event->id) }}
                    </div>
                    @endif
                    
                    <div class="event-card-image">
                        <img src="{{ $event->image_url ?? asset('storage/' . $event->image) }}" alt="{{ $event->name }}">
                        <div class="event-date-badge">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($event->tanggal_mulai ?? now())->format('d M Y') }}
                        </div>
                        <div class="event-category-badge">{{ $event->kategori ?? 'Event' }}</div>
                    </div>
                    
                    <div class="event-card-content">
                        <h3 class="event-card-title">{{ $event->name }}</h3>
                        
                        <div class="event-card-meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $event->lokasi ?? 'SMKN 2 Depok Sleman' }}</span>
                            <span><i class="fas fa-clock"></i> {{ $event->waktu_mulai ?? '08:00' }}</span>
                        </div>
                        
                        <p class="event-card-description">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}</p>
                        
                        <a href="{{ route('events.show', $event->slug) }}" class="event-card-link">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if(method_exists($events, 'links') && $events->hasPages())
                <div class="pagination-container">
                    {{ $events->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-alt empty-icon"></i>
                <h3 class="mb-3">Tidak Ada Event</h3>
                <p class="text-muted mb-4">Tidak ada event yang tersedia saat ini atau sesuai dengan filter yang dipilih</p>
                <a href="{{ route('events.eventonly') }}" class="btn btn-primary">Lihat Semua Event</a>
            </div>
        @endif
    </div>
</div>
@endsection
