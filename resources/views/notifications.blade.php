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
            @if(isset($jumlahNotifBelumDikerjakan) && $jumlahNotifBelumDikerjakan > 0)
                Kamu memiliki <span id="unread-count" class="font-bold text-black">{{ $jumlahNotifBelumDikerjakan }} Notifikasi</span> yang perlu dikerjakan hari ini
            @else
                Semua jadwal perawatan hari ini sudah selesai dikerjakan!
            @endif
        </p>

        <!-- Layout Grid 2 Kolom Full Screen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
            <!-- Hari ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Hari ini</h2>
                
                <div class="space-y-4">
                    @forelse($hariIni as $item)
                    <a href="/jadwal-perawatan" data-notif-id="{{ $item['id'] }}" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-emerald-50/60 transition cursor-pointer group">
                        <span class="red-dot w-3 h-3 bg-red-500 rounded-full shrink-0"></span>
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-solid fa-seedling text-emerald-700 text-xl group-hover:text-emerald-900"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> {{ $item['pesan'] }} - <span class="text-gray-400">{{ $item['waktu'] }}</span>
                        </p>
                    </a>
                    @empty
                    <p class="text-sm text-gray-400 italic">Belum ada jadwal perawatan atau notifikasi untuk tanamanmu hari ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Minggu ini -->
            <div>
                <h2 class="text-lg md:text-xl font-bold text-black mb-6">Minggu ini</h2>
                
                <div class="space-y-4">
                    @forelse($mingguIni as $item)
                    <a href="/jadwal-perawatan" data-notif-id="{{ $item['id'] }}" onclick="markAsRead(this)" class="flex items-center gap-4 p-3 pl-6 rounded-2xl hover:bg-gray-100 transition cursor-pointer group">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-solid fa-seedling text-emerald-700 text-xl group-hover:text-emerald-900"></i>
                        </div>
                        <p class="text-sm md:text-base text-gray-600 leading-tight">
                            <span class="font-bold text-black">Panen Sukses</span> {{ $item['pesan'] }} - <span class="text-gray-400">{{ $item['waktu'] }}</span>
                        </p>
                    </a>
                    @empty
                    <p class="text-sm text-gray-400 italic">Tidak ada jadwal perawatan lainnya di minggu ini.</p>
                    @endforelse
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
            document.querySelectorAll('a[data-notif-id]').forEach(item => {
                const notifId = item.getAttribute('data-notif-id');
                const dot = item.querySelector('.red-dot');
                if (localStorage.getItem('notif_read_' + notifId)) {
                    if (dot) dot.classList.add('hidden');
                    item.classList.add('pl-6');
                }
            });
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