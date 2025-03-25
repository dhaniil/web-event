<style>
    @media (max-width: 640px) {
        .nav-lg{
            display: none;
        }
    }

    @media (max-width: 785px) {
        .nav-lg{
            display: none;
        }
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    .search-result-item {
        padding: 0.5rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
    }

    .search-result-item:hover {
        background-color: #f3f4f6;
    }

    .search-result-type {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
    }

    /* Navbar sticky */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Menambahkan padding untuk content */
    .content-area {
        padding-top: 20px; /* Jarak aman dari navbar */
    }

    /* Style untuk mobile search */
    .mobile-search {
        position: relative;
    }
    
    .mobile-search-input {
        position: absolute;
        right: 100%; /* Mulai dari sebelah kanan */
        top: 0;
        width: 0; /* Hidden awalnya */
        height: 40px;
        border-radius: 20px;
        padding: 0 15px;
        border: 1px solid #ddd;
        outline: none;
        transition: width 0.3s ease;
        opacity: 0;
    }
    
    .mobile-search-input.active {
        width: calc(100vw - 110px); /* Melebar hampir penuh layar */
        opacity: 1;
    }
    
    /* Pindahkan tombol ketika input aktif */
    .mobile-search-btn {
        position: relative;
        z-index: 10;
        transition: background-color 0.3s ease;
    }
</style>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white shadow-sm" id="main-navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo dan brand -->
        <a href="{{ route('events.dashboard') }}" class="navbar-brand d-flex align-items-center text-decoration-none">
            <img src="{{ asset('storage/assets/stembayo.png') }}" alt="Logo Stembayo" width="40" class="me-2">
            <span class="fw-bold text-primary">EVENT STEMBAYO</span>
        </a>
        
        <!-- Search form (desktop) -->
        <div class="d-none d-md-block flex-grow-1 mx-4">
            <form action="{{ route('search') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="query" class="form-control rounded-pill border-0 bg-light" 
                           placeholder="Cari event atau berita..." aria-label="Search">
                    <button class="btn btn-primary rounded-pill ms-2" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tombol pencarian mobile (hanya 1) -->
        <div class="d-flex d-md-none align-items-center">
            <div class="mobile-search">
                <form action="{{ route('search') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="query" class="mobile-search-input" 
                           id="mobileSearchInput" placeholder="Cari...">
                </form>
                <button id="mobileSearchBtn" class="btn btn-primary mobile-search-btn rounded-circle">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Pastikan space di bawah navbar -->
<div class="navbar-spacer" style="height: 56px;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBtn = document.getElementById('mobileSearchBtn');
        const searchInput = document.getElementById('mobileSearchInput');
        
        if (searchBtn && searchInput) {
            // Toggle search input
            searchBtn.addEventListener('click', function(e) {
                if (searchInput.classList.contains('active')) {
                    // Jika input sudah aktif, submit form
                    const form = searchInput.closest('form');
                    if (searchInput.value.trim() !== '') {
                        form.submit();
                    }
                } else {
                    // Jika input belum aktif, aktifkan dan fokus
                    searchInput.classList.add('active');
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                    e.stopPropagation();
                }
            });
            
            // Hapus class active dari input search ketika klik di luar
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchBtn.contains(e.target)) {
                    searchInput.classList.remove('active');
                }
            });
            
            // Submit form ketika pencarian ditekan
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    const form = searchInput.closest('form');
                    form.submit();
                }
            });
        }
    });
</script>
