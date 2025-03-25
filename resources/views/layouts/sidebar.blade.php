<style>
    /* Style untuk sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #f8f9fa;
        position: fixed;
        top: 0;
        left: -280px; /* Diperbesar agar benar-benar tertutup */
        transition: left 0.3s ease;
        z-index: 1990;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        padding-top: 76px; /* Sesuaikan dengan tinggi navbar */
    }

    .sidebar.show {
        left: 0; /* Tampilkan sidebar */
    }
    
    /* Perbaikan style untuk tombol sidebar */
    .sidebar-toggler {
        position: fixed; /* Ubah dari absolute ke fixed */
        top: 76px; /* Sesuaikan dengan tinggi navbar */
        left: 0; /* Saat sidebar tertutup, tombol ada di tepi kiri */
        z-index: 2000; /* Nilai lebih tinggi untuk memastikan selalu di atas */
        background-color: #3c5cff;
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease; /* Samakan durasi transisi dengan sidebar */
    }
    
    /* Tombol bergeser saat sidebar terbuka */
    .sidebar.show + .sidebar-toggler {
        left: 250px; /* Saat sidebar terbuka, tombol bergeser */
    }
    
    .sidebar-toggler:hover {
        background-color: #2a41c8;
    }
    
    /* Style untuk menu sidebar */
    .sidebar-menu {
        padding: 15px;
    }
    
    .sidebar-menu .nav-link {
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 5px;
        color: #495057;
        transition: all 0.2s ease;
    }
    
    .sidebar-menu .nav-link:hover, 
    .sidebar-menu .nav-link.active {
        background-color: #3c5cff;
        color: white;
    }
    
    /* Responsif untuk mobile */
    @media (max-width: 768px) {
        .sidebar {
            width: 80%; /* Lebih lebar pada mobile */
            max-width: 280px;
            left: -100%; /* Gunakan persentase untuk memastikan benar-benar tersembunyi */
            transform: translateX(-10px); /* Tambahan untuk memastikan benar-benar tersembunyi */
        }
        
        .sidebar.show {
            left: 0;
            transform: translateX(0);
        }
        
        .sidebar.show + .sidebar-toggler {
            left: 80%; /* Sesuaikan dengan lebar sidebar mobile */
            max-left: 280px;
        }
        
        /* Perbaiki posisi toggle button pada mobile */
        .sidebar-toggler {
            top: 15px !important;
            width: 32px; /* Sedikit lebih kecil di mobile */
            height: 32px;
        }
        
        /* Pastikan konten tidak bergeser saat sidebar terbuka di mobile */
        #main-content {
            margin-left: 0 !important;
        }
    }
    
    /* Tambahan untuk mencegah scroll horizontal */
    body.sidebar-open {
        overflow-x: hidden;
    }
</style>

<div class="sidebar" id="app-sidebar">
    <div class="sidebar-menu">
        @auth
        <div class="user-info mb-4">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                     alt="Profile Picture" 
                     class="rounded-circle me-3"
                     style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </div>
            @if(auth()->user()->kelas && auth()->user()->jurusan)
            <div class="user-details mb-3">
                <small class="text-muted d-block">
                    <i class="fas fa-graduation-cap me-2"></i>
                    {{ auth()->user()->kelas }} - {{ auth()->user()->jurusan }}
                </small>
            </div>
            @endif
            <hr class="my-3">
        </div>
        @endauth

        <ul class="nav flex-column">
            <!-- Menu yang selalu ditampilkan -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.dashboard') ? 'active' : '' }}" 
                   href="{{ route('events.dashboard') }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('events.eventonly') ? 'active' : '' }}" 
                   href="{{ route('events.eventonly') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Semua Event
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('berita.index') ? 'active' : '' }}" 
                   href="{{ route('berita.index') }}">
                    <i class="fas fa-newspaper me-2"></i> Berita & Acara
                </a>
            </li>

            <!-- Menu untuk user yang sudah login -->
            @auth
            <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('favourites.index') ? 'active' : '' }}" 
                       href="{{ route('favourites.index') }}">
                        <i class="fas fa-heart me-2"></i> Favorit Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" 
                       href="{{ route('profile.edit') }}">
                        <i class="fas fa-user me-2"></i> Profil
                    </a>
                </li>
                @if(auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Admin Panel
                        </a>
                    </li>
                @endif
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            @else
            <li class="nav-item mt-3">
                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </a>
            </li>
            @endauth
        </ul>
    </div>
</div>

<!-- Tombol toggle di luar sidebar -->
<button type="button" class="sidebar-toggler" id="sidebar-toggle-btn">
    <i class="fas fa-bars"></i>
</button>

<script>
// Hapus script sidebar toggle di sini
</script>
