@extends('extend.main')

@section('styles')
<style>
    /* Hapus CSS yang menyembunyikan navbar */
    /* .navbar, #main-navbar {
        display: none !important;
    } */
    
    /* Reset padding untuk body karena navbar disembunyikan */
    /* body {
        padding-top: 0 !important;
        margin: 0 !important;
    } */
    
    /* Header dengan judul dan tombol kembali */
    .search-header {
        background-color: #3c5cff;
        color: white;
        padding: 15px 20px;
        position: sticky;
        top: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .back-button {
        color: white;
        text-decoration: none;
        font-size: 1.5rem;
        padding: 5px;
    }
    
    /* Container utama */
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    /* Form pencarian utama */
    .search-form {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .search-form .form-control {
        height: 46px;
        border-radius: 6px 0 0 6px;
        border: 1px solid #ddd;
        padding-left: 15px;
    }
    
    .search-form .btn {
        border-radius: 0 6px 6px 0;
        background-color: #3c5cff;
        color: white;
        border: none;
        height: 46px;
        font-weight: 500;
    }
    
    /* Modal pencarian untuk mobile */
    .search-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.85);
        z-index: 2000;
        padding: 20px;
        box-sizing: border-box;
    }
    
    .search-modal-content {
        background: white;
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 10px;
        position: relative;
    }
    
    .search-modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        color: #666;
        cursor: pointer;
        background: none;
        border: none;
    }
    
    /* Styling kartu hasil */
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        padding-left: 10px;
        border-left: 4px solid #3c5cff;
    }
    
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .search-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .search-card:hover {
        transform: translateY(-5px);
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
    }
    
    .card-category {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #3c5cff;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
    }
    
    .card-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .card-description {
        color: #666;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .card-link {
        color: #3c5cff;
        text-decoration: none;
        font-weight: 500;
    }
    
    .card-link:hover {
        text-decoration: underline;
    }
    
    /* Tampilan mobile */
    @media (max-width: 768px) {
        .search-container {
            padding: 15px;
        }
        
        .search-form {
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 18px;
        }
        
        .card-grid {
            grid-template-columns: 1fr;
        }
        
        .search-modal-content {
            margin: 30% auto;
        }
    }
    
    /* Tombol pencarian floating untuk mobile */
    .mobile-search-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background-color: #3c5cff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        border: none;
        font-size: 20px;
        z-index: 999;
    }
    
    @media (min-width: 769px) {
        .mobile-search-button {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<!-- Header dengan tombol kembali -->
<div class="search-header">
    <a href="{{ url()->previous() }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="m-0">Hasil Pencarian</h1>
    <span></span> <!-- Placeholder untuk flexbox alignment -->
</div>

<div class="search-container">
    <p class="text-center mb-4 fw-semibold">Kata kunci: <span class="text-primary">"{{ $query }}"</span></p>
    
    <!-- Form pencarian desktop -->
    <div class="search-form d-none d-md-block">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group">
                <input type="text" name="query" class="form-control" value="{{ $query }}" placeholder="Cari event atau berita...">
                <button type="submit" class="btn">
                    <i class="fas fa-search me-2"></i> Cari
                </button>
            </div>
        </form>
    </div>
    
    <!-- Event Terkait -->
    <div class="mb-5">
        <h2 class="section-title">Event Terkait</h2>
        
        @if(count($events) > 0)
            <div class="card-grid">
                @foreach($events as $event)
                    <div class="search-card">
                        <div class="card-image">
                            <img src="{{ $event->image_url ?? asset('storage/' . $event->image) }}" alt="{{ $event->name }}">
                            <span class="card-category">{{ $event->kategori ?? 'Event' }}</span>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">{{ $event->name }}</h3>
                            <p class="card-description">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 100) }}</p>
                            <a href="{{ route('events.show', $event->id) }}" class="card-link">Lihat Detail →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3>Tidak ada event yang cocok</h3>
                <p class="text-muted">Coba gunakan kata kunci yang berbeda atau telusuri semua event kami</p>
                <a href="{{ route('events.eventonly') }}" class="btn btn-primary mt-3">Lihat Semua Event</a>
            </div>
        @endif
    </div>
    
    <!-- Berita Terkait (jika ada) -->
    @if(isset($beritas) && count($beritas) > 0)
        <div class="mb-5">
            <h2 class="section-title">Berita Terkait</h2>
            <div class="card-grid">
                @foreach($beritas as $berita)
                    <div class="search-card">
                        <div class="card-image">
                            <img src="{{ $berita->image_url ?? asset('storage/' . $berita->image) }}" alt="{{ $berita->judul }}">
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">{{ $berita->judul }}</h3>
                            <p class="card-description">{{ \Illuminate\Support\Str::limit(strip_tags($berita->konten), 100) }}</p>
                            <a href="{{ route('berita.show', $berita->id) }}" class="card-link">Baca Selengkapnya →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Tombol search floating untuk mobile -->
<button type="button" class="mobile-search-button" id="openSearchModal">
    <i class="fas fa-search"></i>
</button>

<!-- Modal pencarian untuk mobile -->
<div class="search-modal" id="searchModal">
    <div class="search-modal-content">
        <button type="button" class="search-modal-close" id="closeSearchModal">
            <i class="fas fa-times"></i>
        </button>
        <h4 class="mb-3">Cari Event atau Berita</h4>
        <form action="{{ route('search') }}" method="GET">
            <div class="form-group mb-3">
                <input type="text" name="query" class="form-control" value="{{ $query }}" placeholder="Masukkan kata kunci...">
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-2"></i> Cari
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sembunyikan navbar dari halaman pencarian
        const navbars = document.querySelectorAll('.navbar, #main-navbar');
        navbars.forEach(navbar => {
            navbar.style.display = 'none';
        });
        
        // Modal pencarian untuk mobile
        const modal = document.getElementById('searchModal');
        const openBtn = document.getElementById('openSearchModal');
        const closeBtn = document.getElementById('closeSearchModal');
        
        openBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            setTimeout(() => {
                document.querySelector('#searchModal input').focus();
            }, 100);
        });
        
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        // Tutup modal jika klik di luar modal
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
        
        // Focus pada form pencarian desktop
        const searchInput = document.querySelector('.search-form input[name="query"]');
        if (searchInput && window.innerWidth >= 768) {
            setTimeout(() => {
                searchInput.focus();
                const inputLength = searchInput.value.length;
                searchInput.setSelectionRange(inputLength, inputLength);
            }, 200);
        }
    });
</script>
@endsection 