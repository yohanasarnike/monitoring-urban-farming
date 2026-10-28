<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Urban Farming</title>
    <!-- Tailwind CSS & FontAwesome Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white w-screen min-h-screen m-0 p-8 md:p-14 flex flex-col justify-between">

    <div>
        <!-- Header dengan Tombol Kembali ke Dashboard -->
        <div class="flex justify-between items-center pb-6 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="text-emerald-800 text-2xl md:text-3xl hover:opacity-80 transition flex items-center justify-center">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <h1 class="text-3xl md:text-4xl font-bold text-black">Notifikasi</h1>
            </div>
            <button class="text-emerald-800 text-3xl hover:opacity-80 transition">
                <i class="fa-solid fa-sliders"></i>
            </button>
        </div>
        
        <p class="text-sm md:text-base text-gray-600 my-6">
            Kamu memiliki <span id="unread-count" class="font-bold text-black">3 Notifikasi</span> hari ini
        </p>

        <!-- Layout Grid 2 Kolom Full Screen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
            <!-- Hari ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Hari ini</h2>
                
                <div class="space-y-4">
                    <!-- Item Notifikasi 1 -->
                    <a href="/jadwal-perawatan" data-notif-id="1" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-emerald-50/60 transition cursor-pointer group">
                        <span class="red-dot w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-brands fa-android text-gray-700 text-xl group-hover:text-emerald-800"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">2 menit lalu</span>
                        </p>
                    </a>

                    <!-- Item Notifikasi 2 -->
                    <a href="/jadwal-perawatan" data-notif-id="2" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-emerald-50/60 transition cursor-pointer group">
                        <span class="red-dot w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-brands fa-android text-gray-700 text-xl group-hover:text-emerald-800"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">1 jam lalu</span>
                        </p>
                    </a>

                    <!-- Item Notifikasi 3 -->
                    <a href="/jadwal-perawatan" data-notif-id="3" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-emerald-50/60 transition cursor-pointer group">
                        <span class="red-dot w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-brands fa-android text-gray-700 text-xl group-hover:text-emerald-800"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan pemupukkan - <span class="text-gray-400">1 detik lalu</span>
                        </p>
                    </a>
                </div>
            </div>

            <!-- Minggu ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Minggu ini</h2>
                
                <div class="space-y-4">
                    <!-- Item Notifikasi 4 -->
                    <a href="/jadwal-perawatan" data-notif-id="4" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 pl-6 rounded-2xl hover:bg-gray-100 transition cursor-pointer group">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-brands fa-android text-gray-700 text-xl group-hover:text-emerald-800"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan penyiraman - <span class="text-gray-400">10 januari</span>
                        </p>
                    </a>

                    <!-- Item Notifikasi 5 -->
                    <a href="/jadwal-perawatan" data-notif-id="5" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 pl-6 rounded-2xl hover:bg-gray-100 transition cursor-pointer group">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-brands fa-android text-gray-700 text-xl group-hover:text-emerald-800"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> saatnya melakukan pemupukkan - <span class="text-gray-400">10 maret</span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Menghilangkan Titik Merah & Menyimpan Status Dibaca -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            updateReadStatus();
        });

        function updateReadStatus() {
            let unread = 0;
            document.querySelectorAll('a[data-notif-id]').forEach(item => {
                const notifId = item.getAttribute('data-notif-id');
                const dot = item.querySelector('.red-dot');
                if (localStorage.getItem('notif_read_' + notifId)) {
                    if (dot) dot.classList.add('hidden');
                    item.classList.add('pl-6');
                } else if (dot) {
                    unread++;
                }
            });
            const unreadCountEl = document.getElementById('unread-count');
            if (unreadCountEl) unreadCountEl.textContent = unread + " Notifikasi";
        }

        function markAsRead(element) {
            const notifId = element.getAttribute('data-notif-id');
            if (notifId) {
                localStorage.setItem('notif_read_' + notifId, 'true');
            }
        }
    </script>

</body>
</html>