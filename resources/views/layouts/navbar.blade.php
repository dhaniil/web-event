<style>
    @media (max-width: 640px) {
        .nav-lg{
            display: none;
        }
    }

    @media (max-width: 785px) {
        .nav-lg{
            display: none;
        }
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    .search-result-item {
        padding: 0.5rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
    }

    .search-result-item:hover {
        background-color: #f3f4f6;
    }

    .search-result-type {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
    }

    /* Navbar sticky */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Menambahkan padding untuk content */
    .content-area {
        padding-top: 20px; /* Jarak aman dari navbar */
    }
</style>
<nav class="bg-white fixed w-full p-3 shadow-md z-50">
    <div class="mx-auto flex justify-between items-center">
        <a href="{{ route('events.dashboard') }}" class="text-[#3c5cff] text-xl flex items-center no-underline font-bold">
            <img src="{{ asset('storage/assets/stembayo.png') }}" alt="Logo" width="50" height="50" class="d-inline-block align-middle">
            EVENT STEMBAYO
        </a>
        <div class="nav-lg sm:hidden md:flex space-x-4 items-center">
            <div class="gap-2 flex relative">
                <form onsubmit="handleSubmit(event)" class="flex gap-2">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari event atau berita..." 
                           class="px-3 rounded-full bg-[#e6e6e6] border-none focus:ring-2 transition-all focus:ring-[#3c5cff] focus:outline-none w-64"
                           autocomplete="off">
                    <button type="submit" class="bg-[#3c5cff] px-3 py-1 text-white rounded-full active:scale-95 transition-all">
                    <i class="fas fa-search"></i>
                </button>
                <div id="searchResults" class="search-results"></div>
            </div>
          
        </div>
  
        <button id="menu-toggle" class="md:hidden text-[#3c5cff] focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
  
    <div id="menu" class="lg:hidden max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
        <div class="flex justify-center gap-2 mt-2 relative">
            <form onsubmit="handleMobileSubmit(event)" class="flex gap-2 w-full">
                <input type="text" 
                       id="mobileSearchInput"
                       placeholder="Cari event atau berita..." 
                       class="bg-gray-300 rounded-full focus:ring-2 focus:ring-[#3c5cff] focus:outline-none transition-all px-3 py-1 text-gray-800 w-full"
                       autocomplete="off">
                <button type="submit" class="bg-[#3c5cff] px-4 py-2 text-white rounded-full">
                <i class="fas fa-search"></i>
            </button>
            <div id="mobileSearchResults" class="search-results mt-1"></div>
        </div>
    </div>
</nav>

<script>
    const toggler = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");
    let searchTimeout;

    toggler.addEventListener("click", () => {
        if (menu.classList.contains("max-h-0")) {
            menu.classList.remove("max-h-0");
            menu.classList.add("max-h-[300px]");
        } else {
            menu.classList.add("max-h-0");
            menu.classList.remove("max-h-[300px]");
        }
    });

    document.addEventListener("click", (event) => {
        if (!toggler.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add("max-h-0");
            menu.classList.remove("max-h-[300px]");
        }
    });

    function handleSubmit(event) {
        event.preventDefault();
        performSearch();
    }

    function handleMobileSubmit(event) {
        event.preventDefault();
        performMobileSearch();
    }

    function redirectToSearch(query) {
        if (query && query.length >= 2) {
            window.location.href = `/search?query=${encodeURIComponent(query)}`;
        }
    }

    function handleSearch(query, resultsContainer) {
        if (!query) return;
        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        fetch(`/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                
                if (data.events.length === 0 && data.berita.length === 0) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                let html = '';

                data.events.forEach(event => {
                    html += `
                        <div class="search-result-item" onclick="window.location.href='${event.url}'">
                            <div class="font-medium">${event.title}</div>
                            <div class="text-sm text-gray-600">${event.description || ''}</div>
                            <div class="search-result-type">Event</div>
                        </div>
                    `;
                });

                data.berita.forEach(berita => {
                    html += `
                        <div class="search-result-item" onclick="window.location.href='${berita.url}'">
                            <div class="font-medium">${berita.title}</div>
                            <div class="text-sm text-gray-600">${berita.excerpt || ''}</div>
                            <div class="search-result-type">Berita</div>
                        </div>
                    `;
                });

                if (html) {
                    resultsContainer.innerHTML = html;
                    resultsContainer.style.display = 'block';
                } else {
                    resultsContainer.innerHTML = `
                        <div class="search-result-item">
                            <div class="text-gray-500">Tidak ada hasil ditemukan</div>
                        </div>
                    `;
                    resultsContainer.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultsContainer.style.display = 'none';
            });
    }

    // Desktop search
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            handleSearch(e.target.value, searchResults);
        }, 300);
    });

    // Mobile search
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    const mobileSearchResults = document.getElementById('mobileSearchResults');

    mobileSearchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            handleSearch(e.target.value, mobileSearchResults);
        }, 300);
    });

    // Hide results when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
        if (!mobileSearchInput.contains(e.target) && !mobileSearchResults.contains(e.target)) {
            mobileSearchResults.style.display = 'none';
        }
    });

    function performSearch() {
        const query = searchInput.value;
        if (query.length >= 2) {
            redirectToSearch(query);
        }
    }

    function performMobileSearch() {
        const query = mobileSearchInput.value;
        if (query.length >= 2) {
            redirectToSearch(query);
        }
    }
</script>
