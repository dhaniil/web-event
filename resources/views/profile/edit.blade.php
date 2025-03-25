@extends('extend.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Reset & Base Styles */
    * {
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
    }
    
    /* Layout */
    .content-area {
        padding-top: 80px;
        padding-bottom: 50px;
        min-height: calc(100vh - 100px);
        background-color: #f8f9fa;
    }
    
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 20px;
    }
    
    /* Card Styling */
    .profile-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        position: relative;
    }
    
    .card-title {
        color: #4353FF;
        font-size: 20px;
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        position: relative;
    }
    
    .card-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #4353FF;
    }
    
    /* Profile Picture */
    .profile-picture {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid #f0f0f0;
    }
    
    .image-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn-small {
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 5px;
    }
    
    .btn-primary {
        background-color: #4353FF;
        color: white;
        border: none;
    }
    
    .btn-light {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }
    
    /* Form Styling */
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 14px;
        color: #444;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
    }
    
    .form-row > div {
        flex: 1;
    }
    
    .btn-block {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin-top: 15px;
        font-weight: 600;
    }
    
    /* Sample Card */
    .sample-card {
        background: white;
        padding: 25px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    
    .sample-header {
        color: #4353FF;
        font-size: 20px;
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 10px;
        position: relative;
    }
    
    .sample-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #4353FF;
    }
    
    .sample-content {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .profile-image-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .preview-name {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .preview-jurusan {
        color: #6c757d;
        font-size: 16px;
        margin-bottom: 15px;
    }
    
    .preview-details {
        color: #333;
        font-size: 14px;
        line-height: 1.5;
    }
    
    /* Password Change */
    .password-card {
        margin-top: 30px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="content-area">
    <div class="container">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <h2 class="text-primary fw-bold">Navbar</h2>
        </div>
        
        <div class="profile-container">
            <!-- Left Panel - User Profile -->
            <div class="profile-card">
                <h3 class="card-title">User Profile</h3>
                
                <!-- Profile Picture -->
                <div class="profile-picture">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="profile-image">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ substr(Auth::user()->name, 0, 1) }}&background=4353FF&color=fff" alt="Profile" class="profile-image">
                    @endif
                    
                    <div class="image-buttons">
                        <button type="button" class="btn btn-small btn-primary" id="uploadBtn">Upload</button>
                        <button type="button" class="btn btn-small btn-light" id="deleteBtn">Delete</button>
                        
                        <form id="uploadForm" action="{{ route('profile.update.picture') }}" method="POST" enctype="multipart/form-data" style="display:none;">
                            @csrf
                            <input type="file" name="profile_picture" id="profilePictureInput">
                        </form>
                        
                        <form id="deleteForm" action="{{ route('profile.delete.picture') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
                
                <!-- User Form with Alpine.js state management -->
                <div x-data="{ isEditing: false }">
                    <div x-show="!isEditing" class="text-end mb-3">
                        <button type="button" @click="isEditing = true" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit
                        </button>
                    </div>
                    
                    <form action="{{ route('profile.update.profile') }}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" :disabled="!isEditing">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" :disabled="!isEditing">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nomer" class="form-control" value="{{ Auth::user()->nomer }}" :disabled="!isEditing">
                        </div>
                    
                        <div class="form-row">
                            <div>
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="{{ Auth::user()->kelas }}" :disabled="!isEditing">
                            </div>
                            
                            <div>
                                <label class="form-label">Jurusan</label>
                                <select name="jurusan" class="form-control" :disabled="!isEditing">
                                <option value="">Pilih Jurusan</option>
                                <option value="SIJA A" {{ Auth::user()->jurusan == 'SIJA A' ? 'selected' : '' }}>SIJA A</option>
                                <option value="SIJA B" {{ Auth::user()->jurusan == 'SIJA B' ? 'selected' : '' }}>SIJA B</option>
                                <option value="TFLM A" {{ Auth::user()->jurusan == 'TFLM A' ? 'selected' : '' }}>TFLM A</option>
                                <option value="TFLM B" {{ Auth::user()->jurusan == 'TFLM B' ? 'selected' : '' }}>TFLM B</option>
                                <option value="KA A" {{ Auth::user()->jurusan == 'KA A' ? 'selected' : '' }}>KA A</option>
                                <option value="KA B" {{ Auth::user()->jurusan == 'KA B' ? 'selected' : '' }}>KA B</option>
                                <option value="GP A" {{ Auth::user()->jurusan == 'GP A' ? 'selected' : '' }}>GP A</option>
                                <option value="GP B" {{ Auth::user()->jurusan == 'GP B' ? 'selected' : '' }}>GP B</option>
                                <option value="DPIB A" {{ Auth::user()->jurusan == 'DPIB A' ? 'selected' : '' }}>DPIB A</option>
                                <option value="DPIB B" {{ Auth::user()->jurusan == 'DPIB B' ? 'selected' : '' }}>DPIB B</option>
                                <option value="TKR A" {{ Auth::user()->jurusan == 'TKR A' ? 'selected' : '' }}>TKR A</option>
                                <option value="TKR B" {{ Auth::user()->jurusan == 'TKR B' ? 'selected' : '' }}>TKR B</option>
                                <option value="TOI A" {{ Auth::user()->jurusan == 'TOI A' ? 'selected' : '' }}>TOI A</option>
                                <option value="TOI B" {{ Auth::user()->jurusan == 'TOI B' ? 'selected' : '' }}>TOI B</option>
                                <option value="TEK A" {{ Auth::user()->jurusan == 'TEK A' ? 'selected' : '' }}>TEK A</option>
                                <option value="TEK B" {{ Auth::user()->jurusan == 'TEK B' ? 'selected' : '' }}>TEK B</option>
                                <option value="TKI A" {{ Auth::user()->jurusan == 'TKI A' ? 'selected' : '' }}>TKI A</option>
                                <option value="TKI B" {{ Auth::user()->jurusan == 'TKI B' ? 'selected' : '' }}>TKI B</option>
                                <option value="TP" {{ Auth::user()->jurusan == 'TP' ? 'selected' : '' }}>TP</option>
                                <option value="TBKR" {{ Auth::user()->jurusan == 'TBKR' ? 'selected' : '' }}>TBKR</option>
                                <option value="TITL" {{ Auth::user()->jurusan == 'TITL' ? 'selected' : '' }}>TITL</option>
                            </select>
                        </div>
                    </div>
                    
                        <div class="mt-4" x-show="isEditing">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <button type="button" @click="isEditing = false" class="btn btn-secondary btn-block mt-2">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Right Panel - Preview and Password -->
            <div>
                <!-- Profile Preview -->
                <div class="sample-card">
                    <h3 class="sample-header">Contoh Card Profilnya</h3>
                    
                    <div class="sample-content text-center">
                        <div class="profile-image-container">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="profile-image">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ substr(Auth::user()->name, 0, 1) }}&background=4353FF&color=fff" alt="Profile" class="profile-image">
                            @endif
                        </div>
                        
                        <h4 class="preview-name">{{ Auth::user()->name }}</h4>
                        <p class="preview-jurusan">{{ Auth::user()->jurusan ?? 'RPL' }}</p>
                        
                        <div class="preview-details">
                            {{ Auth::user()->kelas ? Auth::user()->kelas . ' ' . Auth::user()->jurusan : '11 RPL' }}<br>
                            Sistem Informasi Jaringan Aplikasi!<br>
                            SMKN 2 Depok
                        </div>
                    </div>
                </div>
                
                <!-- Password Change -->
                <div class="profile-card password-card">
                    <h3 class="card-title">Change Password</h3>
                    
                    <div x-data="{ isChangingPassword: false }">
                        <div x-show="!isChangingPassword" class="text-end mb-3">
                            <button type="button" @click="isChangingPassword = true" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </div>
                        
                        <form action="{{ route('profile.update.password') }}" method="POST" x-show="isChangingPassword">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Old Password</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save me-2"></i>Save Password
                                </button>
                                <button type="button" @click="isChangingPassword = false" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JavaScript untuk upload dan hapus foto
    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.getElementById('uploadBtn');
        const deleteBtn = document.getElementById('deleteBtn');
        const uploadForm = document.getElementById('uploadForm');
        const deleteForm = document.getElementById('deleteForm');
        const profilePictureInput = document.getElementById('profilePictureInput');
        
        // Handle Upload
        if (uploadBtn) {
            uploadBtn.addEventListener('click', function() {
                profilePictureInput.click();
            });
        }
        
        // Auto submit ketika file dipilih
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    uploadForm.submit();
                }
            });
        }
        
        // Handle Delete
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                if (confirm('Anda yakin ingin menghapus foto profil?')) {
                    deleteForm.submit();
                }
            });
        }
    });
</script>
@endsection
