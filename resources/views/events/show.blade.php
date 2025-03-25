@extends('extend.main')

@section('styles')
    <link rel="stylesheet" href="/css/event-show.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Perbaikan untuk header event agar tidak tertutup navbar */
        .content-area {
            padding-top: 20px;
            margin-top: 0;
        }
        
        .event-container {
            margin-top: 0;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .event-header {
            position: relative;
            height: 400px;
            width: 100%;
            overflow: hidden;
            border-radius: 10px 10px 0 0;
        }
        
        .event-image-wrapper {
            height: 100%;
            width: 100%;
        }
        
        .event-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .event-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));
        }
        
        .event-title-section {
            position: absolute;
            bottom: 30px;
            left: 30px;
            color: white;
            z-index: 5;
        }
        
        /* Style untuk tombol favorit */
        .favorite-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 1.8rem;
            transition: all 0.3s ease;
            padding: 8px;
            color: white;
            z-index: 10;
        }
        
        .favorite-btn:hover {
            transform: scale(1.3);
        }
        
        .favorite-btn .far.fa-heart {
            color: white;
            text-shadow: 0 0 3px rgba(0,0,0,0.5);
        }
        
        .favorite-btn .fas.fa-heart {
            color: #ff3b5c;
            text-shadow: 0 0 3px rgba(0,0,0,0.5);
        }
        
        /* Untuk event tanpa banner */
        .event-title-section-plain {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0;
        }
        
        /* Konten event */
        .event-content {
            padding: 30px;
        }
        
        .event-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .detail-card {
            flex: 1;
            min-width: 200px;
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .icon-wrapper {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eaeeff;
            border-radius: 50%;
            margin-right: 15px;
            color: #3c5cff;
        }
        
        .detail-info h3 {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .detail-info p {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .event-description {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        
        .event-description h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        /* Animasi untuk ikon hati saat di-klik */
        @keyframes heartbeat {
            0% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(1); }
            75% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        
        .heart-beat {
            animation: heartbeat 1s ease-in-out;
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .event-header {
                height: 300px;
            }
            
            .event-title-section {
                left: 15px;
                bottom: 15px;
            }
            
            .event-title-section h1 {
                font-size: 1.5rem;
            }
            
            .event-content {
                padding: 20px 15px;
            }
            
            .event-details {
                flex-direction: column;
                gap: 15px;
            }
            
            .detail-card {
                min-width: 100%;
            }
        }
        
        /* Style untuk notifikasi */
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 20px;
            background: white;
            color: #333;
            border-left: 4px solid #4CAF50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            border-radius: 4px;
            z-index: 9999;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.3s ease;
        }
        
        .toast-notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .toast-success {
            border-left-color: #4CAF50;
        }
        
        .toast-error {
            border-left-color: #F44336;
        }
        
        .toast-info {
            border-left-color: #2196F3;
        }
    </style>
@endsection

@section('content')
<div class="content-area">
    <div class="container">
        <div class="event-container">
            <!-- Banner dan judul -->
            <div class="event-header">
                @if($event->banner || $event->image)
                    <div class="event-image-wrapper">
                        <img src="{{ $event->banner ? $event->banner_url : $event->image_url }}" alt="{{ $event->name }}" class="event-image">
                        <div class="event-overlay"></div>
                        
                        <div class="event-title-section">
                            <h1>{{ $event->name }}</h1>
                            <div class="event-meta">
                                <span class="event-category">{{ $event->kategori }}</span>
                                <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                                @auth
                                    <div class="favourite-container">
                                        <button type="button" class="favorite-btn {{ $event->favouritedBy->contains(auth()->id()) ? 'active' : '' }}" data-event-id="{{ $event->id }}">
                                            <i class="{{ $event->favouritedBy->contains(auth()->id()) ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @else
                    <div class="event-title-section-plain">
                        <h1>{{ $event->name }}</h1>
                        <div class="event-meta">
                            <span class="event-category">{{ $event->kategori }}</span>
                            <span class="event-status {{ strtolower($event->status) }}">{{ ucfirst($event->status) }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Konten detail event - Pastikan area ini terlihat -->
            <div class="event-content" style="display:block; visibility:visible; opacity:1;">
                <!-- Informasi dasar event -->
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

                <!-- Deskripsi event -->
                <div class="event-description">
                    <h2>Tentang Event</h2>
                    <div>
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Bagian ulasan -->
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Temukan semua tombol favorit
        const buttons = document.querySelectorAll('.favorite-btn');
        console.log('Tombol favorit ditemukan:', buttons.length);
        
        // Tambahkan event listener ke setiap tombol
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID event dari atribut data
                const eventId = this.getAttribute('data-event-id');
                
                // Ambil ikon
                const icon = this.querySelector('i');
                if (!icon) return;
                
                // Tampilkan animasi loading
                icon.className = 'fas fa-spinner fa-spin';
                
                // Kirim request ke server
                fetch('/favourite/' + eventId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Data response:', data);
                    
                    if (data.success) {
                        // Update tampilan ikon dan tambahkan animasi
                        if (data.favourited) {
                            // Favorit aktif
                            icon.className = 'fas fa-heart';
                            this.classList.add('active');
                            
                            // Tambahkan animasi heartbeat
                            icon.classList.add('heart-beat');
                            setTimeout(() => {
                                icon.classList.remove('heart-beat');
                            }, 1000);
                        } else {
                            // Favorit tidak aktif
                            icon.className = 'far fa-heart';
                            this.classList.remove('active');
                        }
                        
                        // Tampilkan notifikasi sukses
                        showNotification(data.message, 'success');
                    } else {
                        // Error
                        icon.className = this.classList.contains('active') ? 'fas fa-heart' : 'far fa-heart';
                        showNotification(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    icon.className = this.classList.contains('active') ? 'fas fa-heart' : 'far fa-heart';
                    showNotification('Terjadi kesalahan', 'error');
                });
            });
        });
    });
    
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'info') {
        // Reset notifikasi sebelumnya
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();
        
        // Buat elemen notifikasi
        const notification = document.createElement('div');
        notification.className = `toast-notification toast-${type}`;
        notification.textContent = message;
        
        // Tambahkan ke DOM
        document.body.appendChild(notification);
        
        // Animasi tampil
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Hilangkan setelah beberapa detik
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>

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

<script>
    // Ini adalah script tambahan untuk memastikan navbar berada di atas
    document.addEventListener('DOMContentLoaded', function() {
        // Fix navbar dengan JavaScript untuk memastikan posisinya benar
        const navbar = document.querySelector('.navbar');
        navbar.style.position = 'fixed';
        navbar.style.top = '0';
        navbar.style.left = '0';
        navbar.style.width = '100%';
        navbar.style.zIndex = '1999';
        
        // Periksa apakah header event tertutup navbar
        const eventHeader = document.querySelector('.event-header');
        if (eventHeader) {
            const navbarHeight = navbar.offsetHeight;
            const currentPadding = parseInt(window.getComputedStyle(document.body).paddingTop);
            
            if (currentPadding < navbarHeight) {
                document.body.style.paddingTop = navbarHeight + 'px';
            }
            
            console.log('Navbar height:', navbarHeight);
            console.log('Body padding top:', currentPadding);
        }
    });
</script>

<script>
// Tambahkan script debugging
console.log('Debug page struktur:');
console.log('Event container:', document.querySelector('.event-container'));
console.log('Event content:', document.querySelector('.event-content'));
console.log('Event details:', document.querySelector('.event-details'));
console.log('Detail cards:', document.querySelectorAll('.detail-card').length);

// Force tampilkan konten
document.addEventListener('DOMContentLoaded', function() {
    // Force show content
    setTimeout(function() {
        const eventContent = document.querySelector('.event-content');
        if (eventContent) {
            console.log('Forcing event content visibility');
            eventContent.style.display = 'block';
            eventContent.style.visibility = 'visible';
            eventContent.style.opacity = '1';
            
            // Jika masih bermasalah, coba tambahkan konten secara manual
            if (document.querySelectorAll('.detail-card').length === 0) {
                console.log('Re-creating event details manually');
                // Kode untuk membuat ulang detail cards jika diperlukan
            }
        }
    }, 500);
});
</script>
