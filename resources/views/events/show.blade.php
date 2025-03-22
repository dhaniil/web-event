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
            font-size: 24px;
            color: #fff;
            padding: 0;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .favorite-btn i {
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .favorite-btn.active {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .favorite-btn.active i {
            color: #ff3366;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        .favorite-btn:hover i {
            color: #ff3366;
        }

        .favorite-btn:active {
            transform: scale(0.95);
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

        /* Tambahkan style untuk loading */
        .fa-spin {
            animation: fa-spin 2s infinite linear;
        }
        
        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(359deg); }
        }

        /* Tambahan untuk animasi */
        @keyframes heartBeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.3); }
            28% { transform: scale(1); }
            42% { transform: scale(1.3); }
            70% { transform: scale(1); }
        }
        
        .heart-beat {
            animation: heartBeat 1s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="content-area">
    <div class="event-container">
        <div class="event-header">
            @if($event->banner)
                <div class="event-image-wrapper">
                    <img src="{{ $event->banner_url }}" alt="{{ $event->name }}" class="event-image">
                    <div class="event-overlay"></div>
                    
                    <div class="event-title-section">
                        <h1>{{ $event->name }}</h1>
                        <div class="event-meta">
                            <span class="event-category">{{ $event->kategori }}</span>
                            <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                            @auth
                                <div id="favoriteContainer" class="favourite-container">
                                    <form action="{{ route('favourite.add', $event->id) }}" method="POST" class="favourite-form" id="favouriteForm">
                                        @csrf
                                        <button type="submit" class="favorite-btn {{ $event->favouritedBy->contains(auth()->id()) ? 'active' : '' }}">
                                            <i class="fa{{ $event->favouritedBy->contains(auth()->id()) ? 's' : 'r' }} fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @elseif($event->image)
                <div class="event-image-wrapper">
                    <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="event-image">
                    <div class="event-overlay"></div>
            
            <div class="event-title-section">
                <h1>{{ $event->name }}</h1>
                <div class="event-meta">
                    <span class="event-category">{{ $event->kategori }}</span>
                            <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                    @auth
                                <div id="favoriteContainer" class="favourite-container">
                                    <form action="{{ route('favourite.add', $event->id) }}" method="POST" class="favourite-form" id="favouriteForm">
                                        @csrf
                                        <button type="submit" class="favorite-btn {{ $event->favouritedBy->contains(auth()->id()) ? 'active' : '' }}">
                                            <i class="fa{{ $event->favouritedBy->contains(auth()->id()) ? 's' : 'r' }} fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
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

<!-- Tambahkan debug element di akhir halaman (invisible) -->
<div id="debug-info" style="display: none;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cari form dengan ID yang pasti
        const favoriteForm = document.getElementById('favouriteForm');
        
        if (favoriteForm) {
            // Tambahkan event listener ke form
            favoriteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Ambil elemen button dan icon
                const btn = this.querySelector('.favorite-btn');
                const icon = btn.querySelector('i');
                const originalIcon = icon.className;
                
                // Tampilkan loading
                icon.className = 'fas fa-spinner fa-spin';
                
                // Kirim request dengan metode lebih sederhana
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update tampilan berdasarkan status favorit
                        if (data.favourited) {
                            btn.classList.add('active');
                            icon.className = 'fas fa-heart';
                        } else {
                            btn.classList.remove('active');
                            icon.className = 'far fa-heart';
                        }
                        
                        // Tampilkan pesan sukses
                        showToast(data.message, 'success');
                    } else {
                        // Kembalikan ikon asli jika gagal
                        icon.className = originalIcon;
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    // Kembalikan ikon asli jika terjadi error
                    icon.className = originalIcon;
                    showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                });
            });
        }
        
        // Deteksi session message
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    });
    
    // Fungsi toast tetap sama
    function showToast(message, type = 'info') {
        const existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerText = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 10);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>

<script>
    // Tambahkan setelah script Anda yang sudah ada
    
    // Fallback jika Ajax gagal
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Menerapkan fallback regular form submit');
        
        // Deteksi jika ada pesan sukses dari session
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        
        // Deteksi jika ada error dari session
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
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
        console.log('Toggle ulasan form dipanggil');
        
        const ulasanForm = document.getElementById('ulasanForm');
        
        if (!ulasanForm) {
            console.log('Membuat form ulasan baru');
            
            // Jika form belum ada, buat form
            const formContainer = document.createElement('div');
            formContainer.id = 'ulasanForm';
            formContainer.innerHTML = `
                <div class="form-title">Tambahkan Ulasan</div>
                <form id="formUlasan">
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
            
            // Tambahkan event listener untuk form submission
            document.getElementById('formUlasan').addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form ulasan disubmit');
                
                const submitBtn = this.querySelector('.submit-btn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                submitBtn.disabled = true;
                
                const formData = new FormData(this);
                console.log('Form data:', Object.fromEntries(formData));
                
                fetch('{{ route("ulasan.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.success) {
                        showToast(data.message || 'Ulasan berhasil ditambahkan', 'success');
                        
                        // Tambahkan ulasan baru ke daftar tanpa refresh
                        addNewUlasanToList({
                            user: {
                                name: '{{ auth()->user()->name ?? "Anda" }}'
                            },
                            rating: formData.get('rating'),
                            komentar: formData.get('komentar'),
                            created_at: 'Baru saja'
                        });
                        
                        // Sembunyikan form
                        toggleUlasanForm();
                    } else {
                        submitBtn.innerHTML = 'Kirim Ulasan';
                        submitBtn.disabled = false;
                        showToast(data.message || 'Gagal menambahkan ulasan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = 'Kirim Ulasan';
                    submitBtn.disabled = false;
                    showToast('Terjadi kesalahan saat mengirim ulasan', 'error');
                });
            });
            
            // Tampilkan form
            formContainer.style.display = 'block';
        } else {
            // Toggle visibility form yang sudah ada
            console.log('Toggle form yang sudah ada');
            ulasanForm.style.display = ulasanForm.style.display === 'none' ? 'block' : 'none';
        }
    }

    // Fungsi untuk menambahkan ulasan baru ke daftar
    function addNewUlasanToList(ulasan) {
        console.log('Menambahkan ulasan baru ke daftar:', ulasan);
        
        const emptyUlasan = document.querySelector('.empty-ulasan');
        if (emptyUlasan) {
            // Hapus pesan "belum ada ulasan"
            emptyUlasan.remove();
            
            // Buat container ulasan jika belum ada
            if (!document.querySelector('.ulasan-list')) {
                const ulasanList = document.createElement('div');
                ulasanList.className = 'ulasan-list';
                document.querySelector('.ulasan-section').appendChild(ulasanList);
            }
        }
        
        const ulasanList = document.querySelector('.ulasan-list');
        const ulasanItem = document.createElement('div');
        ulasanItem.className = 'ulasan-item';
        
        // Update counter ulasan
        const counterEl = document.querySelector('.ulasan-header h2');
        const match = counterEl.textContent.match(/\((\d+)\)/);
        if (match) {
            const count = parseInt(match[1]) + 1;
            counterEl.textContent = counterEl.textContent.replace(/\(\d+\)/, `(${count})`);
        }
        
        // Buat HTML untuk ulasan baru
        ulasanItem.innerHTML = `
            <div class="ulasan-header">
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=${ulasan.user.name.substr(0, 1)}&background=4F46E5&color=fff&rounded=true&size=40" 
                         alt="User" 
                         class="cdn-avatar"
                         width="40" 
                         height="40">
                    <div>
                        <h4>${ulasan.user.name}</h4>
                        <div class="rating">
                            ${Array(5).fill().map((_, i) => 
                                `<i class="fas fa-star ${i < ulasan.rating ? 'text-warning' : 'text-muted'}"></i>`
                            ).join('')}
                        </div>
                    </div>
                </div>
                <div class="ulasan-date">
                    ${ulasan.created_at}
                </div>
            </div>
            <div class="ulasan-content">
                ${ulasan.komentar}
            </div>
        `;
        
        // Tambahkan ke awal daftar
        if (ulasanList.firstChild) {
            ulasanList.insertBefore(ulasanItem, ulasanList.firstChild);
        } else {
            ulasanList.appendChild(ulasanItem);
        }
        
        // Animasi untuk highlight ulasan baru
        ulasanItem.style.animation = 'fadeIn 1s';
    }
</script>
@endsection

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast("{{ session('success') }}", 'success');
    });
</script>
@endif

<script>
    // Deteksi jika JavaScript dinonaktifkan
    document.documentElement.classList.add('js-enabled');
</script>

<noscript>
    <style>
        /* Tampilkan formulir biasa jika JavaScript dinonaktifkan */
        .js-enabled .favourite-form {
            display: none;
        }
        
        .favourite-form-fallback {
            display: block;
        }
    </style>
    
    <!-- Form fallback untuk browser tanpa JavaScript -->
    @auth
        <form action="{{ route('favourite.add', $event->id) }}" method="POST" class="favourite-form-fallback">
            @csrf
            <button type="submit" class="favorite-btn {{ $event->favouritedBy->contains(auth()->id()) ? 'active' : '' }}">
                <i class="fa{{ $event->favouritedBy->contains(auth()->id()) ? 's' : 'r' }} fa-heart"></i>
            </button>
        </form>
    @endauth
</noscript>
