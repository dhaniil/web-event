<style>
    .footer-container a {
        text-decoration: none;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .footer-container a:hover {
        transform: translateX(5px);
    }
    
    .footer-container a:hover::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 100%;
        height: 1px;
        background-image: linear-gradient(to right, #ffffff 50%, transparent 50%);
        background-size: 10px 1px;
        background-repeat: repeat-x;
    }
</style>

<footer class="bg-gradient-to-br from-[#5356ff] to-[#3730a3] relative overflow-hidden py-16 text-white">
    <!-- Decorative circles -->
    <div class="absolute w-[500px] h-[500px] bg-white/15 rounded-full -top-48 -right-24 blur-[80px]"></div>
    <div class="absolute w-[400px] h-[400px] bg-white/15 rounded-full -bottom-36 -left-24 blur-[70px]"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="footer-container flex flex-wrap justify-between gap-8">
            <!-- About Section -->
            <div class="flex-1 min-w-[250px]">
                <h5 class="text-lg font-semibold mb-4">Tentang Stembayo Events</h5>
                <p class="text-white/80 mb-6">Platform event resmi SMKN 2 Depok Sleman yang menampilkan berbagai event</p>
                <div class="flex space-x-4">
                    <a href="https://www.instagram.com/event.stembayo/" class="hover:-translate-y-1 transition-transform">
                        <i class="bi bi-instagram text-2xl text-white"></i>
                    </a>
                    <a href="https://web.facebook.com/stembayolover/" class="hover:-translate-y-1 transition-transform">
                        <i class="bi bi-facebook text-2xl text-white"></i>
                    </a>
                    <a href="https://www.youtube.com/@smkn2depoksleman/" class="hover:-translate-y-1 transition-transform">
                        <i class="bi bi-youtube text-2xl text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="flex-1 min-w-[200px]">
                <h5 class="text-lg font-semibold mb-4">Menu Utama</h5>
                <ul class="space-y-3">
                    <li><a href="/" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Beranda</a></li>
                    <li><a href="/events" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Event</a></li>
                    <li><a href="/berita" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Berita</a></li>
                    <li><a href="/galeri" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Galeri</a></li>
                </ul>
            </div>

            <!-- Related Sites -->
            <div class="flex-1 min-w-[200px]">
                <h5 class="text-lg font-semibold mb-4">Situs Terkait</h5>
                <ul class="space-y-3">
                    <li><a href="https://smkn2depoksleman.sch.id" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Website Utama</a></li>
                    <li><a href="https://perpus.smkn2depoksleman.sch.id" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">Perpustakaan</a></li>
                    <li><a href="https://elearning.stembayo.sch.id/" class="text-white/80 hover:text-white hover:translate-x-1 transition-all inline-block">E-Learning</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="flex-1 min-w-[250px]">
                <h5 class="text-lg font-semibold mb-4">Hubungi Kami</h5>
                <div class="space-y-3">
                    <p class="flex items-start space-x-3">
                        <i class="bi bi-geo-alt-fill mt-1"></i>
                        <span class="text-white/80">Mrican, Caturtunggal, Depok, Sleman<br>Daerah Istimewa Yogyakarta 55281</span>
                    </p>
                    <p class="flex items-center space-x-3">
                        <i class="bi bi-telephone-fill"></i>
                        <span class="text-white/80">+62 274 513515</span>
                    </p>
                    <p class="flex items-center space-x-3">
                        <i class="bi bi-envelope-fill"></i>
                        <span class="text-white/80">info@smkn2depoksleman.sch.id</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-12 pt-8 border-t border-white/10 text-center">
            <p class="text-white/80">&copy; {{ date('Y') }} Stembayo Events. All rights reserved.</p>
        </div>
    </div>
</footer>
