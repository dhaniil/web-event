@extends('extend.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* CSS Reset dan Base Styles */
    * {
        box-sizing: border-box;
    }
    
    /* Layout Utama */
    .content-area {
        padding-top: 80px;
        padding-bottom: 30px;
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
        flex: 1;
        min-width: 320px;
        transition: transform 0.2s, box-shadow 0.2s;
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
    
    /* Change Password Card */
    .password-card {
        flex: 1;
        min-width: 320px;
        max-width: 500px;
    }
    
    /* Example Profile Card */
    .example-profile {
        margin-top: 40px;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        text-align: center;
    }
    
    .example-profile h3 {
        font-size: 18px;
        color: #5356FF;
        margin-bottom: 20px;
    }
    
    .example-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }
    
    .example-name {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .example-jurusan {
        font-size: 14px;
        color: #5356FF;
        margin-bottom: 10px;
    }
    
    .example-school {
        font-size: 14px;
        color: #666;
    }
    
    /* Form Input icons */
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }
    
    .input-with-icon input,
    .input-with-icon select {
        padding-left: 40px;
    }
    
    /* Alert messages */
    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: #e6f7ed;
        color: #0d6832;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    /* Responsive */
    @media screen and (max-width: 768px) {
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="content-area">
    <div class="profile-container">
        <!-- Profile Card (now on top) -->
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
                    <!-- Form Upload -->
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
                    <button type="button" id="submitPicture" class="btn btn-sm btn-primary" onclick="submitProfilePicture()">
                        Submit Foto
                    </button>
                </div>
            </div>
            
            <!-- User Information Form - Perbaiki nama field sesuai controller -->
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
        
        <!-- Password Card (now below) -->
        <div class="profile-card password-card">
            <h2 class="profile-card-header">Change Password</h2>
            
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
            
            <!-- Example Profile Card -->
            <div class="example-profile">
                <h3>Contoh Card Profilnya</h3>
                <img src="https://ui-avatars.com/api/?name=N&background=f8f9fa&color=5356FF&size=80" alt="Example Profile" class="example-avatar">
                <h4 class="example-name">Nama</h4>
                <p class="example-jurusan">Sistem Informasi Jaringan Aplikasi</p>
                <p class="example-school">SMKN 2 Depok</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referensi elemen-elemen
        const profileForm = document.getElementById('profileForm');
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const formInputs = profileForm.querySelectorAll('input, select');
        const avatarActionButtons = document.getElementById('avatarActionButtons');
        const profilePictureInput = document.getElementById('profile_picture');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const mainAvatar = document.querySelector('.avatar');
        
        // Set mode awal: View Mode
        setViewMode();
        
        // Event untuk tombol Edit
        editButton.addEventListener('click', function() {
            setEditMode();
        });
        
        // Event saat memilih gambar
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
                    console.log("File dipilih:", file.name, file.type, file.size);
                    
                    // Validasi file
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                        this.value = '';
                        return;
                    }
                    
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB');
                        this.value = '';
                        return;
                    }
                    
                    // Preview gambar
            const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Fungsi untuk submit form foto profil
        window.submitProfilePicture = function() {
            const avatarForm = document.getElementById('avatarForm');
            if (avatarForm) {
                // Tampilkan loading state
                const submitBtn = document.getElementById('submitPicture');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
                submitBtn.disabled = true;
                
                // Debug - tampilkan apa yang akan disubmit
                console.log("Submitting form with:", profilePictureInput.files[0]?.name);
                
                // Gunakan FormData dan fetch API untuk upload dengan AJAX
                const formData = new FormData(avatarForm);
                fetch(avatarForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Upload response:", data);
                    if (data.success) {
                        // Update avatar dengan gambar baru
                        const timestamp = new Date().getTime();
                        if (data.image_url) {
                            mainAvatar.src = data.image_url + '?v=' + timestamp;
                        } else if (data.path) {
                            mainAvatar.src = '{{ asset('storage') }}/' + data.path + '?v=' + timestamp;
                        }
                        
                        // Reset form dan tampilan
                        avatarForm.reset();
                        previewContainer.style.display = 'none';
                        
                        // Tampilkan notifikasi sukses
                        alert('Foto profil berhasil diperbarui!');
                        
                        // Set ke view mode
                        setViewMode();
                    } else {
                        alert('Error: ' + (data.error || 'Terjadi kesalahan saat mengupload foto'));
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Submit Foto';
                    }
                })
                .catch(error => {
                    console.error("Upload error:", error);
                    alert('Terjadi kesalahan saat mengupload foto. Silakan coba lagi.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Submit Foto';
                });
            }
        };
        
        // Fungsi untuk set View Mode
        function setViewMode() {
            // Disable semua input
            formInputs.forEach(input => {
                input.disabled = true;
            });
            
            // Sembunyikan tombol dan form terkait dengan avatar
            if (avatarActionButtons) avatarActionButtons.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'none';
            
            // Tampilkan tombol Edit dan sembunyikan tombol Simpan
            editButton.style.display = 'block';
            saveButton.style.display = 'none';
        }
        
        // Fungsi untuk set Edit Mode
        function setEditMode() {
            // Enable semua input
            formInputs.forEach(input => {
                input.disabled = false;
            });
            
            // Tampilkan tombol upload/delete avatar
            if (avatarActionButtons) avatarActionButtons.style.display = 'flex';
            
            // Sembunyikan tombol Edit dan tampilkan tombol Simpan
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
        
        // Form validasi password
        const passwordForm = document.getElementById('passwordForm');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama!');
        }
    });
        }
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        });
    }, 5000);
    });
</script>
@endsection






