@extends('extend.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* CSS Reset dan Base Styles */
    * {
        box-sizing: border-box;
    }
    
    /* Layout Utama - Tambah padding atas yang lebih besar */
    .content-area {
        padding-top: 120px; /* Dari 80px ke 120px untuk lebih jauh dari navbar */
        padding-bottom: 50px; /* Tambah padding bawah */
        background-color: #f8f9fa;
        min-height: calc(100vh - 60px); /* Tinggi viewport dikurangi tinggi navbar */
    }
    
    /* Profile Container */
    .profile-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Profile Card Styles */
    .profile-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 30px;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    /* User Profile Card */
    .user-profile-card {
        flex: 1;
        min-width: 320px;
        max-width: 500px;
    }
    
    /* Right Column */
    .right-column {
        flex: 1;
        min-width: 320px;
        max-width: 500px;
        display: flex;
        flex-direction: column;
    }
    
    .profile-card-header {
        color: #5356FF;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
        position: relative;
        padding-bottom: 12px;
    }
    
    .profile-card-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: #5356FF;
        border-radius: 2px;
    }
    
    /* Avatar */
    .avatar-container {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f0f0;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    
    .avatar:hover {
        transform: scale(1.05);
    }
    
    /* Upload/Delete Buttons */
    .avatar-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
    }
    
    .upload-btn, .delete-btn {
        padding: 8px 15px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .upload-btn {
        background-color: #5356FF;
        color: white;
    }
    
    .upload-btn:hover {
        background-color: #4146e5;
        transform: translateY(-2px);
    }
    
    .delete-btn {
        background-color: #f5f5f5;
        color: #333;
        border: 1px solid #ddd;
    }
    
    .delete-btn:hover {
        background-color: #f0f0f0;
        border-color: #ccc;
    }
    
    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .form-control:focus {
        border-color: #5356FF;
        box-shadow: 0 0 0 3px rgba(83, 86, 255, 0.15);
        outline: none;
    }
    
    /* Form Layout: Two Columns */
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-col {
        flex: 1;
    }
    
    /* Button Styles */
    .btn {
        padding: 12px 15px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background-color: #5356FF;
        color: white;
        width: 100%;
        box-shadow: 0 4px 10px rgba(83, 86, 255, 0.2);
    }
    
    .btn-primary:hover {
        background-color: #4146e5;
        box-shadow: 0 6px 15px rgba(83, 86, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    /* Preview aktif */
    .preview-active {
        border-color: #5356FF;
        box-shadow: 0 0 0 3px rgba(83, 86, 255, 0.3);
        animation: pulse 1s;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    /* Preview container */
    #previewContainer {
        text-align: center;
        margin-top: 15px;
    }
    
    #imagePreview {
        max-width: 150px;
        border-radius: 50%;
        border: 3px solid #5356FF;
        box-shadow: 0 4px 12px rgba(83, 86, 255, 0.2);
        transition: all 0.3s;
    }
    
    /* Password Section Styling */
    .password-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .password-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .password-header {
        color: #5356FF;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
        position: relative;
        padding-bottom: 12px;
    }
    
    .password-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #5356FF;
        border-radius: 2px;
    }
    
    /* Profile Preview Card - Card kanan */
    .profile-preview-card-container {
        background-color: white;
        text-align: center;
        height: fit-content;
    }
    
    .preview-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .preview-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f0f0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto 20px;
        transition: transform 0.3s ease;
    }
    
    .preview-avatar:hover {
        transform: scale(1.05);
    }
    
    .preview-name {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .preview-jurusan {
        font-size: 16px;
        color: #5356FF;
        margin-bottom: 5px;
    }
    
    .preview-class {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }
    
    .preview-badge {
        display: inline-block;
        padding: 5px 15px;
        background-color: #eef2ff;
        color: #5356FF;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
    }
    
    .preview-info {
        margin-top: 25px;
        padding: 20px;
        background-color: #f9fafb;
        border-radius: 8px;
        width: 100%;
        text-align: left;
    }
    
    .info-item {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    
    .info-item i {
        width: 25px;
        color: #5356FF;
        margin-right: 10px;
        text-align: center;
        font-size: 16px;
    }
    
    .info-label {
        font-weight: 600;
        font-size: 14px;
        color: #555;
        width: 80px;
    }
    
    .info-value {
        font-size: 14px;
        color: #333;
        flex: 1;
    }
    
    /* Input with icon */
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #5356FF;
    }
    
    .input-with-icon input,
    .input-with-icon select {
        padding-left: 40px;
    }
    
    /* Responsive adjustment */
    @media screen and (max-width: 768px) {
        .user-profile-card {
            order: 1;
        }
        
        .right-column {
            order: 2;
        }
        
        .profile-container {
            flex-direction: column;
            gap: 20px;
        }
        
        .user-profile-card,
        .password-card {
            max-width: 100%;
        }
        
        .form-row {
            flex-direction: column;
            gap: 15px;
        }
        
        .profile-card {
            padding: 20px;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="content-area">
    <div class="profile-container">
        <!-- Left Card - Form Edit Profile -->
        <div class="profile-card user-profile-card">
            <h2 class="profile-card-header">Edit Profile</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Avatar -->
            <div class="avatar-container">
                @if(Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}?v={{ rand(1000,9999) }}" alt="Profile Picture" class="avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ substr(Auth::user()->name, 0, 1) }}&background=5356FF&color=fff&size=150" alt="Profile" class="avatar">
                @endif
                
                <!-- Form Upload, ini hanya muncul saat edit mode -->
                <div class="avatar-actions" id="avatarActionButtons" style="display: none;">
                    <!-- Form Upload dengan ID yang unik dan konsisten -->
                    <form action="{{ route('profile.update.picture') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        <label for="profile_picture" class="upload-btn">
                            <i class="fas fa-upload"></i> Upload
                        </label>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;">
                    </form>
                    
                    <!-- Form Delete jika ada foto profil -->
                    @if(Auth::user()->profile_picture)
                        <form action="{{ route('profile.delete.picture') }}" method="POST">
                            @csrf
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>
                
                <!-- Preview dan tombol submit (hanya muncul saat foto dipilih) -->
                <div id="previewContainer" style="display: none; margin-top: 15px;">
                    <div class="preview-image-container" style="margin-bottom: 10px;">
                        <img id="imagePreview" src="" alt="Preview" style="max-width: 150px; border-radius: 50%; border: 3px solid #5356FF;">
                    </div>
                    <button type="button" id="submitPicture" class="btn btn-sm btn-primary">
                        Submit Foto
                    </button>
                </div>
            </div>
            
            <!-- User Information Form -->
            <form action="{{ route('profile.update.profile') }}" method="POST" id="profileForm">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nama</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="nomer">No HP</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="text" id="nomer" name="nomer" class="form-control" value="{{ Auth::user()->nomer }}" disabled>
                    </div>
                    @error('nomer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="kelas">Kelas</label>
                        <div class="input-with-icon">
                            <i class="fas fa-graduation-cap"></i>
                            <select id="kelas" name="kelas" class="form-control" disabled>
                                <option value="" {{ Auth::user()->kelas == '' ? 'selected' : '' }}>Pilih Kelas</option>
                                <option value="10" {{ Auth::user()->kelas == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ Auth::user()->kelas == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ Auth::user()->kelas == '12' ? 'selected' : '' }}>12</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <label for="jurusan">Jurusan</label>
                        <div class="input-with-icon">
                            <i class="fas fa-laptop-code"></i>
                            <select id="jurusan" name="jurusan" class="form-control" disabled>
                                <option value="" {{ Auth::user()->jurusan == '' ? 'selected' : '' }}>Pilih Jurusan</option>
                                <option value="RPL" {{ Auth::user()->jurusan == 'RPL' ? 'selected' : '' }}>RPL</option>
                                <option value="TKJ" {{ Auth::user()->jurusan == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                                <option value="MM" {{ Auth::user()->jurusan == 'MM' ? 'selected' : '' }}>MM</option>
                                <option value="SIJA" {{ Auth::user()->jurusan == 'SIJA' ? 'selected' : '' }}>SIJA</option>
                                <option value="TEI" {{ Auth::user()->jurusan == 'TEI' ? 'selected' : '' }}>TEI</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Edit/Save Button -->
                <button type="button" id="editButton" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </button>
                
                <button type="submit" id="saveButton" class="btn btn-primary" style="display: none;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
        
        <!-- Right Column - Profile Preview & Password Change -->
        <div class="right-column">
            <!-- Profile Preview Card -->
            <div class="profile-card profile-preview-card-container">
                <h2 class="profile-card-header">Preview Profil Anda</h2>
                
                <div class="preview-content">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}?v={{ rand(1000,9999) }}" alt="Profile Picture" class="preview-avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ substr(Auth::user()->name, 0, 1) }}&background=5356FF&color=fff&size=150" alt="Profile" class="preview-avatar">
                    @endif
                    
                    <h4 class="preview-name">{{ Auth::user()->name }}</h4>
                    
                    <div class="preview-jurusan">
                        {{ Auth::user()->jurusan ? Auth::user()->jurusan : 'Belum Diatur' }}
                    </div>
                    
                    <div class="preview-class">
                        {{ Auth::user()->kelas ? 'Kelas ' . Auth::user()->kelas : 'Kelas Belum Diatur' }}
                    </div>
                    
                    <span class="preview-badge">
                        <i class="fas fa-user"></i> SMKN 2 Depok
                    </span>
                    
                    <div class="preview-info">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ Auth::user()->email }}</span>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">No. HP:</span>
                            <span class="info-value">{{ Auth::user()->nomer ?: 'Belum Diatur' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Password Change Card -->
            <div class="profile-card password-card">
                <h3 class="profile-card-header password-header">Ganti Password</h3>
                
                <form action="{{ route('profile.update.password') }}" method="POST" id="passwordForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="current_password" name="current_password" class="form-control">
                        </div>
                        @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-key"></i>
                            <input type="password" id="new_password" name="password" class="form-control">
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-check"></i>
                            <input type="password" id="confirm_password" name="password_confirmation" class="form-control">
                        </div>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileForm = document.getElementById('profileForm');
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const formInputs = profileForm.querySelectorAll('input, select');
        const avatarActionButtons = document.getElementById('avatarActionButtons');
        const profilePictureInput = document.getElementById('profile_picture');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const mainAvatar = document.querySelector('.avatar');
        const submitPictureButton = document.getElementById('submitPicture');
        
        // Set mode awal: View Mode
        setViewMode();
        
        // Event untuk tombol Edit
        editButton.addEventListener('click', function() {
            setEditMode();
        });
        
        // Event saat memilih gambar
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function(event) {
                handleFileUpload(event);
            });
        }
        
        // Tambahkan event listener untuk tombol submit foto
        if (submitPictureButton) {
            submitPictureButton.addEventListener('click', function() {
                // Tampilkan loader
                submitPictureButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitPictureButton.disabled = true;
                submitProfilePicture();
            });
        }
        
        // Fungsi untuk menangani upload file
        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                // Validasi file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showNotification('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.', 'error');
                    event.target.value = '';
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Ukuran file terlalu besar! Maksimal 2MB', 'error');
                    event.target.value = '';
                    return;
                }
                
                // Preview gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    // Animasi untuk menarik perhatian ke preview
                    imagePreview.classList.add('preview-active');
                    setTimeout(() => {
                        imagePreview.classList.remove('preview-active');
                    }, 1000);
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Fungsi untuk submit form foto profil
        function submitProfilePicture() {
            // Pastikan element selalu ditemukan dengan selector yang lebih spesifik
            const avatarForm = document.querySelector('form#avatarForm');
            const profilePictureInput = document.querySelector('input#profile_picture');
            
            // Jika form tidak ditemukan, coba gunakan pendekatan alternatif
            if (!avatarForm) {
                // Upload file tanpa form
                if (profilePictureInput && profilePictureInput.files && profilePictureInput.files.length > 0) {
                    const formData = new FormData();
                    formData.append('profile_picture', profilePictureInput.files[0]);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    
                    // Lanjutkan dengan proses upload
                    uploadProfilePicture(formData, "{{ route('profile.update.picture') }}");
                } else {
                    showNotification('Silakan pilih foto profil terlebih dahulu', 'error');
                    resetSubmitButton();
                }
                return;
            }
            
            // Jika form ditemukan tapi file tidak ada
            if (!profilePictureInput || !profilePictureInput.files || profilePictureInput.files.length === 0) {
                showNotification('Silakan pilih foto profil terlebih dahulu', 'error');
                resetSubmitButton();
                return;
            }
            
            // Gunakan FormData dari form
            const formData = new FormData(avatarForm);
            
            // Upload dengan form asli
            uploadProfilePicture(formData, avatarForm.action);
        }
        
        // Fungsi untuk reset tombol submit ke keadaan awal
        function resetSubmitButton() {
            if (submitPictureButton) {
                submitPictureButton.innerHTML = 'Submit Foto';
                submitPictureButton.disabled = false;
            }
        }
        
        // Fungsi untuk melakukan upload dengan FormData
        function uploadProfilePicture(formData, uploadUrl) {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Lakukan fetch dengan headers yang benar (tanpa Content-Type header)
            fetch(uploadUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update avatar dengan gambar baru
                    const timestamp = new Date().getTime();
                    const mainAvatar = document.querySelector('.avatar');
                    mainAvatar.src = data.image_url + '?v=' + timestamp; // Update gambar profil
                    
                    // Tambahkan efek transisi
                    mainAvatar.classList.add('preview-active');
                    setTimeout(() => {
                        mainAvatar.classList.remove('preview-active');
                    }, 1000);
                    
                    // Reset form jika ada
                    const avatarForm = document.querySelector('form#avatarForm');
                    if (avatarForm) avatarForm.reset();
                    
                    // Sembunyikan preview
                    const previewContainer = document.getElementById('previewContainer');
                    if (previewContainer) previewContainer.style.display = 'none';
                    
                    // Tampilkan notifikasi sukses
                    showNotification('Foto profil berhasil diperbarui!', 'success');
                    
                    // Refresh halaman dengan fade out-in effect untuk memastikan perubahan terlihat
                    setTimeout(() => {
                        document.body.style.opacity = '0.5';
                        document.body.style.transition = 'opacity 0.5s';
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    }, 1000);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan saat mengupload foto', 'error');
                    resetSubmitButton();
                }
            })
            .catch(error => {
                showNotification('Terjadi kesalahan saat mengupload foto. Silakan coba lagi.', 'error');
                resetSubmitButton();
            });
        }
        
        // Fungsi untuk menampilkan notifikasi yang lebih rapi
        function showNotification(message, type = 'info') {
            // Cek apakah ada container notifikasi, jika tidak maka buat
            let notifContainer = document.getElementById('notification-container');
            if (!notifContainer) {
                notifContainer = document.createElement('div');
                notifContainer.id = 'notification-container';
                notifContainer.style.position = 'fixed';
                notifContainer.style.top = '20px';
                notifContainer.style.right = '20px';
                notifContainer.style.zIndex = '9999';
                document.body.appendChild(notifContainer);
            }
            
            // Buat element notifikasi
            const notification = document.createElement('div');
            notification.className = 'alert alert-' + (type === 'error' ? 'danger' : (type === 'success' ? 'success' : 'info'));
            notification.style.marginBottom = '10px';
            notification.style.minWidth = '250px';
            notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(50px)';
            notification.style.transition = 'all 0.3s ease';
            
            // Ikon berdasarkan jenis notifikasi
            let icon = '';
            if (type === 'success') icon = '<i class="fas fa-check-circle"></i> ';
            else if (type === 'error') icon = '<i class="fas fa-exclamation-circle"></i> ';
            else icon = '<i class="fas fa-info-circle"></i> ';
            
            notification.innerHTML = icon + message;
            
            // Tambahkan tombol close
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close';
            closeBtn.style.position = 'absolute';
            closeBtn.style.right = '10px';
            closeBtn.style.top = '10px';
            closeBtn.style.fontSize = '16px';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.background = 'transparent';
            closeBtn.style.border = 'none';
            closeBtn.innerHTML = '&times;';
            closeBtn.addEventListener('click', function() {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(50px)';
                setTimeout(() => {
                    notifContainer.removeChild(notification);
                }, 300);
            });
            notification.appendChild(closeBtn);
            
            // Tambahkan notifikasi ke container
            notifContainer.appendChild(notification);
            
            // Tampilkan notifikasi dengan animasi
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Otomatis hilangkan setelah beberapa detik
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(50px)';
                setTimeout(() => {
                    if (notification.parentNode === notifContainer) {
                        notifContainer.removeChild(notification);
                    }
                }, 300);
            }, 5000);
        }
        
        // Untuk kompatibilitas dengan kode lama
        window.handleFileUpload = handleFileUpload;
        window.submitProfilePicture = submitProfilePicture;
        
        // Fungsi untuk set View Mode
        function setViewMode() {
            formInputs.forEach(input => {
                input.disabled = true;
            });
            if (avatarActionButtons) avatarActionButtons.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'none';
            editButton.style.display = 'block';
            saveButton.style.display = 'none';
        }
        
        // Fungsi untuk set Edit Mode
        function setEditMode() {
            formInputs.forEach(input => {
                input.disabled = false;
            });
            if (avatarActionButtons) avatarActionButtons.style.display = 'flex';
            editButton.style.display = 'none';
            saveButton.style.display = 'block';
        }
        
        // Kembalikan ke view mode jika ada pesan sukses
        @if(session('success'))
            setViewMode();
        @endif
        
        // Aktifkan edit mode jika ada error
        @if(session('error'))
            setEditMode();
        @endif
    });
</script>
@endsection






