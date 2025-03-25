<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Event Stembayo</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CSS Kustom -->
    @vite('resources/css/app.css')
    @include('assets/asset')
    @yield('styles')

    <!-- Styles -->
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
        }
        
        .navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 1999 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }
        
        .content-area {
            padding-top: 76px !important; /* Sesuaikan dengan tinggi navbar */
            width: 100%;
        }
        
        /* Style untuk animasi navbar */
        .navbar-scrolled {
            background-color: white !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }
        
        /* Responsivitas untuk mobile */
        @media (max-width: 768px) {
            .navbar-brand span {
                font-size: 1rem !important;
            }
            
            .navbar .container-fluid {
                padding-left: 60px; /* Berikan ruang untuk tombol sidebar */
            }
            
            .content-area {
                padding-top: 60px !important; /* Lebih kecil di mobile */
            }
            
            /* Pastikan tombol sidebar tetap di tempat */
            .sidebar-toggler {
                top: 10px !important;
                left: 10px !important;
            }
        }
    </style>
    
    <!-- Tambahkan ini di bagian head, sebelum semua script lain -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    @include('layouts.navbar', ['user' => $user ?? null])
    
    <!-- Sidebar -->
    @include('layouts.sidebar', ['user' => $user ?? null])
    
    <!-- Konten Utama -->
    <div class="content" id="main-content">
        @yield('content')
    </div>
    
    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen sidebar dan tombol toggle yang benar
            const sidebar = document.getElementById('app-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const content = document.querySelector('.content');
            const body = document.body;
            
            // Fungsi untuk update margin content saat sidebar terbuka/tertutup
            function updateContentMargin() {
                if (window.innerWidth >= 992) { // Hanya berlaku di layar besar
                    if (sidebar && sidebar.classList.contains('show')) {
                        if (content) content.style.marginLeft = '250px';
                        toggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>'; // Ubah ikon saat terbuka
                        body.classList.add('sidebar-open'); // Tambahkan class ke body
                    } else {
                        if (content) content.style.marginLeft = '0';
                        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>'; // Ubah ikon saat tertutup
                        body.classList.remove('sidebar-open'); // Hapus class dari body
                    }
                } else {
                    if (content) content.style.marginLeft = '0';
                    toggleBtn.innerHTML = sidebar.classList.contains('show') ? 
                        '<i class="fas fa-chevron-left"></i>' : '<i class="fas fa-bars"></i>';
                    
                    // Tambah/hapus class di body berdasarkan status sidebar
                    if (sidebar.classList.contains('show')) {
                        body.classList.add('sidebar-open');
                    } else {
                        body.classList.remove('sidebar-open');
                    }
                }
            }
            
            // Inisialisasi
            if (sidebar) {
                // Cek localStorage untuk sidebar state
                const savedState = localStorage.getItem('sidebarVisible');
                if (savedState === 'true') {
                    sidebar.classList.add('show');
                    updateContentMargin();
                }
                
                // Listener untuk window resize
                window.addEventListener('resize', updateContentMargin);
            }
            
            // Tambahkan event listener untuk tombol toggle
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    
                    // Simpan state di localStorage
                    localStorage.setItem('sidebarVisible', sidebar.classList.contains('show'));
                    
                    // Update margin content dan icon
                    updateContentMargin();
                    
                    // Paksa reflow untuk memperbarui posisi tombol
                    if (window.innerWidth <= 768) {
                        setTimeout(function() {
                            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                        }, 50);
                    }
                });
            }
            
            // Tambahkan event listener untuk klik di luar sidebar di mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && 
                    sidebar && 
                    sidebar.classList.contains('show') && 
                    !sidebar.contains(event.target) && 
                    event.target !== toggleBtn) {
                    sidebar.classList.remove('show');
                    localStorage.setItem('sidebarVisible', 'false');
                    updateContentMargin();
                }
            });
            
            // Fix navbar position
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                navbar.style.position = 'fixed';
                navbar.style.top = '0';
                navbar.style.width = '100%';
                navbar.style.zIndex = '1999';
                
                // Adjust content padding based on navbar height
                const contentArea = document.querySelector('.content-area');
                if (contentArea) {
                    const navbarHeight = navbar.offsetHeight;
                    contentArea.style.paddingTop = navbarHeight + 'px';
                }
            }
        });
    </script>
    
    @yield('scripts')
    
    <!-- Notifikasi dengan SweetAlert -->
    @if(session('success'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
            });
        </script>
    @endif
    
    <!-- Tambahkan fallback jika CDN Alpine.js gagal dimuat -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (typeof Alpine === 'undefined') {
                    console.error('Alpine.js not loaded. Loading from fallback...');
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js';
                    script.defer = true;
                    document.head.appendChild(script);
                }
            }, 1000);
        });
    </script>
</body>
</html>
