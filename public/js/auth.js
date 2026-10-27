window.addEventListener('load', function() {
    const splash = document.getElementById('splash-screen');
    
    // Tambahkan pengaman: jalankan hanya jika elemen splash-screen benar-benar ada di halaman itu
    if (splash) {
        if (!sessionStorage.getItem('hasSeenSplash')) {
            setTimeout(function() {
                splash.classList.add('fade-out');
                sessionStorage.setItem('hasSeenSplash', 'true');
            }, 1800);
        } else {
            splash.style.display = 'none';
        }
    }
});