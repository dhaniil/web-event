@extends('extend.main')

@section('styles')
    <link rel="stylesheet" href="/css/event-show.css">
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Kode JavaScript dieksekusi');
        // Cari form dengan ID yang pasti
        const favoriteForm = document.getElementById('favouriteForm');

        if (favoriteForm) {
            // Inisialisasi tampilan tombol saat halaman dimuat
            const btn = favoriteForm.querySelector('.favorite-btn');
            const icon = btn.querySelector('i');
            if (btn.classList.contains('active')) {
                icon.className = 'fas fa-heart';
            } else {
                icon.className = 'far fa-heart';
            }

            // Tambahkan event listener ke form
            favoriteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Tombol favorit diklik');

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
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(this)
                })
                .then(response => {
                    console.log('Response diterima', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Data dari response', data);
                    if (data.success) {
                        // Update tampilan berdasarkan status favorit
                        if (data.favourited) {
                            console.log('Event difavoritkan');
                            btn.classList.add('active');
                            icon.className = 'fas fa-heart';
                        } else {
                            console.log('Event tidak difavoritkan');
                            btn.classList.remove('active');
                            icon.className = 'far fa-heart';
                        }

                        console.log('Tampilan diupdate');
                        // Tampilkan pesan sukses
                        showToast(data.message, 'success');
                    } else {
                        console.log('Terjadi kesalahan', data.message);
                        // Kembalikan ikon asli jika gagal
                        icon.className = originalIcon;
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
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
