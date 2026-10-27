<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="w-screen h-screen m-0 p-0 overflow-hidden relative flex flex-col justify-between items-center text-center">

    <!-- Background Gambar Tanaman Aesthetic dengan Overlay Gelap Transparan -->
    <div class="absolute inset-0 z-0">
        <!-- Gambar Tanaman Hijau Segar & Visual Menarik (Unsplash High Quality) -->
        <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?q=80&w=1920&auto=format&fit=crop" 
             alt="Urban Farming Plant Background" 
             class="w-full h-full object-cover">
        <!-- Overlay Gradasi Warna Hijau Tua agar Teks Tampak Sangat Jelas -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#042f14]/80 via-[#042f14]/60 to-[#042f14]/90 backdrop-blur-[1px]"></div>
    </div>

    <!-- Spacer Kosong Atas (Penyebab Teks Bisa Benar-benar Pas di Tengah) -->
    <div class="relative z-10 pt-10"></div>

    <!-- Content Utama: Teks Selamat Datang Tepat di Tengah Layar -->
    <div class="relative z-10 max-w-3xl px-6 my-auto">
        <span class="bg-lime-400/20 text-lime-300 border border-lime-400/30 text-xs md:text-sm font-semibold px-4 py-1.5 rounded-full inline-block mb-4 shadow-sm tracking-wide">
            🌱 Layanan Tanya Pakar
        </span>
        <h1 class="text-white font-bold text-3xl md:text-6xl leading-tight tracking-wide drop-shadow-lg">
            Selamat datang di<br>
            <span class="text-lime-300">Konsultasi Urban Farming</span>
        </h1>
        <p class="text-emerald-100 text-sm md:text-lg mt-4 max-w-xl mx-auto font-light leading-relaxed drop-shadow">
            Solusi praktis perawatan tanaman, penanganan hama, dan pemupukan kebun rumah kamu.
        </p>
    </div>

    <!-- Tombol Get Started di Bawah -->
    <div class="relative z-10 w-full max-w-md pb-16 md:pb-20 px-8">
        <a href="/konsultasi/chat" class="block w-full py-4 border-2 border-white bg-white/10 backdrop-blur-md text-white rounded-full font-bold text-xl md:text-2xl hover:bg-white hover:text-[#042f14] transition-all duration-300 shadow-2xl transform hover:-translate-y-1">
            Get Started
        </a>
    </div>

</body>
</html>