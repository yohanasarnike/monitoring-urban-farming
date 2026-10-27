<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white w-screen min-h-screen m-0 p-8 md:p-14 flex flex-col justify-between">

    <div>
        <!-- Header -->
        <div class="flex justify-between items-center pb-6 border-b border-gray-200">
            <h1 class="text-3xl md:text-4xl font-bold text-black">Notifikasi</h1>
            <button class="text-emerald-800 text-3xl hover:opacity-80 transition">
                <i class="fa-solid fa-sliders"></i>
            </button>
        </div>
        
        <p class="text-sm md:text-base text-gray-600 my-6">
            Kamu memiliki <span class="font-bold text-black">1 Notifikasi</span> hari ini
        </p>

        <!-- Layout Grid 2 Kolom Full Screen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
            <!-- Hari ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Hari ini</h2>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <span class="w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-android text-gray-700 text-xl"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">2 menit lalu</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-android text-gray-700 text-xl"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">1 jam lalu</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-android text-gray-700 text-xl"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan pemupukkan - <span class="text-gray-400">1 detik lalu</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Minggu ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Minggu ini</h2>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4 pl-6">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-android text-gray-700 text-xl"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">10 januari</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 pl-6">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-android text-gray-700 text-xl"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan pemupukkan - <span class="text-gray-400">10 maret</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>