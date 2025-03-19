document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategoriSelect');
    const filterButton = document.getElementById('filterButton');
    const resetButton = document.getElementById('resetButton');
    
    // Handle filter button click
    filterButton.addEventListener('click', function() {
        const selectedKategori = kategoriSelect.value;
        const currentUrl = new URL(window.location.href);
        
        if (selectedKategori) {
            currentUrl.searchParams.set('kategori', selectedKategori);
        } else {
            currentUrl.searchParams.delete('kategori');
        }
        
        window.location.href = currentUrl.toString();
    });
    
    // Handle reset button click
    resetButton.addEventListener('click', function() {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('kategori');
        window.location.href = currentUrl.toString();
    });
    
    // Animate cards on page load
    animateCards();
});

// Card animation function
function animateCards() {
    const cards = document.querySelectorAll('.event-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });
} 