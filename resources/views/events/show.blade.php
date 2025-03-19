@extends('extend.main')

@section('styles')
    <style>
        /* Inline CSS untuk halaman show */
        .event-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .event-image-wrapper {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            height: 400px;
            width: 100%;
        }

        .event-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background-image: linear-gradient(transparent, rgba(0,0,0,0.8));
        }

        .event-title-section {
            position: absolute;
            bottom: 30px;
            left: 30px;
            color: white;
            z-index: 2;
            width: calc(100% - 60px);
        }

        .event-title-section h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .event-category, .event-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(8px);
        }

        .event-category {
            background-color: rgba(230, 240, 255, 0.8);
            color: #3c5cff;
        }

        .event-status {
            background-color: rgba(240, 240, 240, 0.8);
            color: #333;
        }

        .event-status.selesai {
            background-color: rgba(212, 237, 218, 0.8);
            color: #155724;
        }

        .event-status.sedang-berlangsung {
            background-color: rgba(204, 229, 255, 0.8);
            color: #004085;
        }

        .event-status.dibatalkan {
            background-color: rgba(248, 215, 218, 0.8);
            color: #721c24;
        }

        .event-status.ditunda {
            background-color: rgba(255, 243, 205, 0.8);
            color: #856404;
        }

        .favorite-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #fff;
            padding: 5px 8px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .favorite-btn.active {
            color: #ff3366;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .event-content {
            margin-top: 30px;
        }

        .event-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3c5cff;
        }

        .detail-info {
            flex: 1;
        }

        .detail-info h3 {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-info p {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        .detail-info .time {
            font-size: 14px;
            color: #666;
        }

        .event-description {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .event-description h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            position: relative;
            padding-left: 15px;
        }

        .event-description h2:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3c5cff;
            border-radius: 2px;
        }

        .event-description p {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
        }

        /* Ulasan section styling */
        .ulasan-section {
            margin-top: 30px;
        }

        .ulasan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .ulasan-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            position: relative;
            padding-left: 15px;
            margin: 0;
        }

        .ulasan-header h2:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3c5cff;
            border-radius: 2px;
        }

        .tambah-ulasan-btn {
            background-color: #3c5cff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .tambah-ulasan-btn:hover {
            background-color: #2a3eb1;
            transform: translateY(-2px);
        }

        .empty-ulasan {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
        }

        .empty-ulasan i {
            font-size: 40px;
            color: #3c5cff;
            margin-bottom: 15px;
        }

        .empty-ulasan h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-ulasan p {
            font-size: 14px;
            color: #666;
            margin-bottom: 0;
        }

        /* CDN Avatar style */
        .cdn-avatar {
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f0f4ff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Responsif untuk tablet dan mobile */
        @media (max-width: 768px) {
            .event-title-section {
                bottom: 20px;
                left: 20px;
                width: calc(100% - 40px);
            }
            
            .event-title-section h1 {
                font-size: 22px;
                margin-bottom: 10px;
            }
            
            .event-details {
                grid-template-columns: 1fr;
            }

            .event-image-wrapper {
                height: 300px;
            }
        }

        @media (max-width: 576px) {
            .event-title-section {
                bottom: 15px;
                left: 15px;
                width: calc(100% - 30px);
            }
            
            .event-title-section h1 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .event-meta {
                gap: 6px;
            }
            
            .event-category, .event-status {
                padding: 4px 10px;
                font-size: 12px;
            }

            .event-image-wrapper {
                height: 250px;
                margin-bottom: 15px;
            }

            .detail-card {
                padding: 12px;
            }

            .icon-wrapper {
                width: 35px;
                height: 35px;
            }

            .detail-info h3 {
                font-size: 13px;
            }

            .detail-info p {
                font-size: 15px;
            }
        }

        /* CSS untuk ulasan */
        .ulasan-list {
            margin-top: 20px;
        }
        
        .ulasan-item {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .ulasan-item .ulasan-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .ulasan-item .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .ulasan-item .user-info h4 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .ulasan-item .rating {
            display: flex;
            gap: 3px;
        }
        
        .ulasan-item .rating .fas.fa-star.text-warning {
            color: #ffc107;
        }
        
        .ulasan-item .rating .fas.fa-star.text-muted {
            color: #dee2e6;
        }
        
        .ulasan-item .ulasan-date {
            font-size: 12px;
            color: #6c757d;
        }
        
        .ulasan-item .ulasan-content {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        
        /* Form ulasan style */
        #ulasanForm {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: none;
        }
        
        #ulasanForm .form-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        
        #ulasanForm .rating-select {
            display: flex;
            gap: 5px;
            margin-bottom: 15px;
        }
        
        #ulasanForm .rating-select .star {
            font-size: 24px;
            color: #dee2e6;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
        #ulasanForm .rating-select .star:hover,
        #ulasanForm .rating-select .star.active {
            color: #ffc107;
        }
        
        #ulasanForm textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 15px;
        }
        
        #ulasanForm .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        #ulasanForm .cancel-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #f8f9fa;
            color: #333;
            cursor: pointer;
        }
        
        #ulasanForm .submit-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #3c5cff;
            color: white;
            cursor: pointer;
        }
        
        #ulasanForm .submit-btn:hover {
            background-color: #2a3eb1;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .toast-success {
            background-color: #28a745;
        }
        
        .toast-info {
            background-color: #17a2b8;
        }
        
        .toast-error {
            background-color: #dc3545;
        }
    </style>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="content-area">
    <div class="event-container">
        <div class="event-header">
            @if($event->image)
                <div class="event-image-wrapper">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image">
                    <div class="event-overlay"></div>
                    
                    <div class="event-title-section">
                        <h1>{{ $event->name }}</h1>
                        <div class="event-meta">
                            <span class="event-category">{{ $event->kategori }}</span>
                            <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                            @auth
                                <button class="favorite-btn {{ $event->favouritedBy()->where('user_id', auth()->id())->exists() ? 'active' : '' }}"
                                        onclick="document.getElementById('favouriteForm').submit();">
                                    <i class="fa-heart {{ $event->favouritedBy()->where('user_id', auth()->id())->exists() ? 'fas' : 'far' }}"></i>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <div class="event-title-section" style="position: relative; color: #333; margin-bottom: 20px;">
                    <h1>{{ $event->name }}</h1>
                    <div class="event-meta" style="margin-bottom: 10px;">
                        <span class="event-category">{{ $event->kategori }}</span>
                        <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                    </div>
                </div>
            @endif
            
            <div class="event-content">
                <div class="event-details">
                    <div class="detail-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="detail-info">
                            <h3>Tanggal</h3>
                            <p>{{ \Carbon\Carbon::parse($event->tanggal_mulai)->isoFormat('D MMMM Y') }}</p>
                            @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                <p>- {{ \Carbon\Carbon::parse($event->tanggal_selesai)->isoFormat('D MMMM Y') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="detail-info">
                            <h3>Waktu</h3>
                            <p class="time">{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }} WIB</p>
                        </div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-info">
                            <h3>Lokasi</h3>
                            <p>{{ $event->lokasi ?? 'Tidak disebutkan' }}</p>
                        </div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="detail-info">
                            <h3>Penyelenggara</h3>
                            <p>{{ $event->penyelenggara ?? 'Tidak disebutkan' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="event-description">
                    <h2>Tentang Event</h2>
                    <div>
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
                
                <div class="ulasan-section">
                    <div class="ulasan-header">
                        <h2>Ulasan ({{ $event->ulasan()->count() }})</h2>
                        @auth
                            <button class="tambah-ulasan-btn" onclick="toggleUlasanForm()">
                                <i class="fas fa-plus"></i> Tambah Ulasan
                            </button>
                        @endauth
                    </div>
                    
                    @if($event->ulasan()->count() > 0)
                        <!-- Tampilkan ulasan yang ada -->
                        <div class="ulasan-list">
                            @foreach($event->ulasan as $ulasan)
                                <div class="ulasan-item">
                                    <div class="ulasan-header">
                                        <div class="user-info">
                                            <img src="https://ui-avatars.com/api/?name={{ substr($ulasan->user->name ?? 'User', 0, 1) }}&background=4F46E5&color=fff&rounded=true&size=40" 
                                                 alt="User" 
                                                 class="cdn-avatar"
                                                 width="40" 
                                                 height="40">
                                            <div>
                                                <h4>{{ $ulasan->user->name ?? 'Pengguna' }}</h4>
                                                <div class="rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $ulasan->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ulasan-date">
                                            {{ $ulasan->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="ulasan-content">
                                        {{ $ulasan->komentar }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-ulasan">
                            <i class="far fa-comment-alt"></i>
                            <h3>Belum ada ulasan untuk event ini</h3>
                            <p>Jadilah yang pertama memberikan ulasan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tambahkan di awal script
    window.onerror = function(message, source, lineno, colno, error) {
        console.log('Global error handler:', message, source, lineno, colno, error);
        showToast('Error: ' + message, 'error');
        return true;
    };
    
    // Tambahkan fungsi ini untuk debug
    function debugFavourite() {
        console.log('Available routes:');
        console.log('/favourite/{event} - POST - {{ route('favourite.add', 1) }}');
        console.log('/favourite/{event} - DELETE - {{ route('favourite.remove', 1) }}');
        console.log('/events/{event}/favourite - POST - {{ route('events.favourite', 1) }}');
    }
    
    // Panggil saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        debugFavourite();
    });

    // Fungsi untuk menangani favorite event
    function toggleFavorite(eventId) {
        // Implementasi AJAX untuk menangani favorite/unfavorite
        fetch(`/favourite/${eventId}`, {  // Ubah URL ke endpoint yang benar
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const btn = document.querySelector('.favorite-btn');
            const icon = btn.querySelector('i');
            
            if (data.success) {  // Perhatikan respons dari endpoint menggunakan 'success'
                btn.classList.add('active');
                icon.classList.remove('far');
                icon.classList.add('fas');
                // Tambahkan feedback visual
                showToast('Event ditambahkan ke favorit!', 'success');
            } else {
                // Jika sudah favorit, coba unfavorite
                unfavoriteEvent(eventId);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Jika error, coba endpoint alternatif
            tryAlternativeEndpoint(eventId);
        });
    }
    
    // Fungsi untuk mencoba unfavorite jika sudah favorit
    function unfavoriteEvent(eventId) {
        fetch(`/favourite/${eventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            const btn = document.querySelector('.favorite-btn');
            const icon = btn.querySelector('i');
            
            if (data.success) {
                btn.classList.remove('active');
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('Event dihapus dari favorit!', 'info');
            }
        })
        .catch(error => {
            console.error('Error unfavoriting:', error);
            showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        });
    }
    
    // Fungsi untuk mencoba endpoint alternatif
    function tryAlternativeEndpoint(eventId) {
        fetch(`/events/${eventId}/favourite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Alternative endpoint failed: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const btn = document.querySelector('.favorite-btn');
            const icon = btn.querySelector('i');
            
            if (data.favourited) {
                btn.classList.add('active');
                icon.classList.remove('far');
                icon.classList.add('fas');
                showToast('Event ditambahkan ke favorit!', 'success');
            } else {
                btn.classList.remove('active');
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('Event dihapus dari favorit!', 'info');
            }
        })
        .catch(error => {
            console.error('Alternative endpoint error:', error);
            showToast('Tidak dapat menambahkan ke favorit. Silakan coba lagi nanti.', 'error');
        });
    }
    
    // Fungsi untuk menampilkan toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = message;
        document.body.appendChild(toast);
        
        // Tampilkan toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Sembunyikan dan hapus toast setelah 3 detik
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Fungsi untuk mengganti avatar
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mengubah semua avatar ke CDN
        function replaceAvatarsWithCDN() {
            // Mencari semua elemen img yang mungkin merupakan avatar
            const avatarSelectors = [
                '.user-avatar', '.avatar-img', '.profile-image', '.profile-picture',
                'img[alt="avatar"]', 'img[alt="Avatar"]', 'img[alt="user"]', 'img[alt="User"]',
                'img[alt="profile"]', 'img[alt="Profile"]', '.avatar', '.profile-img',
                'img[src*="avatar"]', 'img[src*="profile"]', 'img[src*="user"]'
            ];
            
            const avatars = document.querySelectorAll(avatarSelectors.join(', '));
            
            // URL avatar default dari CDN - bisa disesuaikan dengan nama pengguna jika tersedia
            let userInitial = 'User';
            @auth
                userInitial = '{{ substr(auth()->user()->name, 0, 1) }}';
            @endauth
            
            const defaultAvatarUrl = `https://ui-avatars.com/api/?name=${userInitial}&background=4F46E5&color=fff&rounded=true&size=150`;
            
            // Ganti semua avatar
            avatars.forEach(avatar => {
                // Handler untuk error loading
                avatar.onerror = function() {
                    this.src = defaultAvatarUrl;
                    this.onerror = null; // Mencegah loop
                };
                
                // Jika merupakan default avatar atau image tidak ditemukan, langsung ganti
                if (avatar.src && (
                    avatar.src.includes('default-avatar.jpg') || 
                    avatar.src.includes('avatar.jpg') || 
                    avatar.src.includes('default-user.png') ||
                    avatar.src.includes('user-default.jpg')
                )) {
                    avatar.src = defaultAvatarUrl;
                }
                
                // Tambahkan class untuk styling konsisten
                avatar.classList.add('cdn-avatar');
            });
        }
        
        // Jalankan fungsi penggantian avatar
        replaceAvatarsWithCDN();
        
        // Deteksi dan hapus error CSS
        const links = document.querySelectorAll('link[rel="stylesheet"]');
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && (href.includes('show.css') || href.includes('empty-state.css') || href.includes('dashboard.css'))) {
                // Hapus link yang menyebabkan error
                link.parentNode.removeChild(link);
            }
        });
    });
</script>
@endsection

@section('scripts')
<script>
    // Resource Error Handler
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mencatat error loading resource
        function handleResourceError(event) {
            const target = event.target;
            
            // Hanya tangani jika target adalah resource yang gagal dimuat
            if (target.tagName === 'LINK' || target.tagName === 'SCRIPT' || target.tagName === 'IMG') {
                console.warn(`Failed to load resource: ${target.src || target.href}`);
                
                // Jika CSS, coba hapus untuk menghindari cascading error
                if (target.tagName === 'LINK' && target.rel === 'stylesheet') {
                    target.disabled = true;
                    console.info(`Disabled stylesheet: ${target.href}`);
                }
                
                // Jika gambar avatar, ganti dengan CDN
                if (target.tagName === 'IMG' && target.src && target.src.includes('avatar')) {
                    let userInitial = 'User';
                    @auth
                        userInitial = '{{ substr(auth()->user()->name, 0, 1) }}';
                    @endauth
                    
                    target.src = `https://ui-avatars.com/api/?name=${userInitial}&background=4F46E5&color=fff&rounded=true&size=150`;
                    target.classList.add('cdn-avatar');
                }
            }
        }
        
        // Listen untuk error loading resource
        window.addEventListener('error', handleResourceError, true);
    });
    
    // Fungsi toggle untuk form ulasan
    function toggleUlasanForm() {
        const ulasanForm = document.getElementById('ulasanForm');
        
        if (!ulasanForm) {
            // Jika form belum ada, buat form
            const formContainer = document.createElement('div');
            formContainer.id = 'ulasanForm';
            formContainer.innerHTML = `
                <div class="form-title">Tambahkan Ulasan</div>
                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="rating-select">
                        <span class="rating-label">Rating:</span>
                        <div class="stars">
                            <i class="star fas fa-star" data-value="1"></i>
                            <i class="star fas fa-star" data-value="2"></i>
                            <i class="star fas fa-star" data-value="3"></i>
                            <i class="star fas fa-star" data-value="4"></i>
                            <i class="star fas fa-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="5">
                    </div>
                    <textarea name="komentar" placeholder="Tulis ulasan Anda di sini..." required></textarea>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="toggleUlasanForm()">Batal</button>
                        <button type="submit" class="submit-btn">Kirim Ulasan</button>
                    </div>
                </form>
            `;
            
            // Masukkan form sebelum daftar ulasan
            const ulasanHeader = document.querySelector('.ulasan-header');
            ulasanHeader.parentNode.insertBefore(formContainer, ulasanHeader.nextSibling);
            
            // Tambahkan event listeners untuk rating stars
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    document.getElementById('rating').value = value;
                    
                    // Reset semua bintang
                    stars.forEach(s => s.classList.remove('active'));
                    
                    // Aktifkan bintang yang dipilih dan sebelumnya
                    stars.forEach(s => {
                        if (s.getAttribute('data-value') <= value) {
                            s.classList.add('active');
                        }
                    });
                });
            });
            
            // Aktifkan semua bintang secara default (rating 5)
            stars.forEach(s => s.classList.add('active'));
            
            // Tampilkan form
            formContainer.style.display = 'block';
        } else {
            // Toggle visibility form yang sudah ada
            ulasanForm.style.display = ulasanForm.style.display === 'none' ? 'block' : 'none';
        }
    }
</script>
@endsection
