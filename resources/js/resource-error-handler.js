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
        }
    }
    
    // Listen untuk error loading resource
    window.addEventListener('error', handleResourceError, true);
}); 