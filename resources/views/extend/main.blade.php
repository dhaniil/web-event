<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Stembayo</title>
    
    <!-- CSS -->
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('assets/asset')
    <!-- <link rel="stylesheet" href="{{ asset('css/show.css') }}"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    @yield('styles')

    {{-- Remove or modify the navbar section to not display login/register for authenticated users --}}
    <script>
        // Add this script to the head section to hide auth buttons as early as possible
        document.addEventListener('DOMContentLoaded', function() {
            if ({{ auth()->check() ? 'true' : 'false' }}) {
                // Find all login/register buttons in the navbar
                const authButtons = document.querySelectorAll('.auth-button, .nav-item-auth, .dropdown-auth');
                
                // Hide them
                authButtons.forEach(btn => {
                    if (btn) btn.style.display = 'none';
                });
            }
        });
    </script>
</head>
<body>
@include('layouts.navbar', ['user' => $user])
@include('layouts.sidebar', ['user' => $user])
    
    <div class="content">
        @yield('content')
    </div>
    

    @include('layouts.footer')

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarState', () => ({
                isSidebarVisible: localStorage.getItem('sidebarVisible') === 'true',
                toggleSidebar() {
                    this.isSidebarVisible = !this.isSidebarVisible;
                    localStorage.setItem('sidebarVisible', this.isSidebarVisible);
                }
            }))
        })
    </script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    @yield('scripts')
    
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
</body>
</html>
