<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi Masuk - Admin Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col md:flex-row text-gray-800">

    <!-- SIDEBAR HIJAU TUA KIRI -->
    <aside class="w-full md:w-72 bg-[#065f2a] text-white flex flex-col justify-between p-6 shrink-0">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center">
                    <i class="fa-solid fa-seedling text-lime-300 text-xl"></i>
                </div>
                <span class="font-bold text-xl tracking-wide">Urban Farming</span>
            </div>

            <div class="flex items-center gap-3 pb-6 mb-6 border-b border-white/20">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#065f2a] flex items-center justify-center font-bold text-xl shadow">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div>
                    <p class="font-bold text-sm leading-tight">Admin Urban</p>
                    <p class="text-xs text-emerald-200">Pakar Pertanian</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition font-semibold text-sm">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.monitoring') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 transition font-semibold text-sm">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span>Monitoring</span>
                </a>
                <a href="{{ route('admin.konsultasi') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl bg-white/15 text-lime-300 font-bold text-sm shadow-sm">
                    <i class="fa-regular fa-comments w-5 text-center"></i>
                    <span>Konsultasi</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-white/20 mt-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-200 hover:bg-red-500/20 hover:text-white transition text-sm font-semibold cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA KANAN -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="w-10"></div>
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-extrabold text-black">Daftar Konsultasi Masuk</h1>
                <p class="text-sm md:text-base font-bold text-gray-800 mt-1">
                    Kelola {{ $totalHariIni }} konsultasi baru hari ini
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.konsultasi') }}" title="Refresh Data" class="relative text-gray-700 hover:text-[#065f2a] text-xl transition">
                    <i class="fa-regular fa-bell"></i>
                    @if($countBelum > 0)
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                    @endif
                </a>
                <div class="w-9 h-9 rounded-full bg-emerald-100 text-[#065f2a] flex items-center justify-center font-bold">
                    <i class="fa-solid fa-seedling"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-4 bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                <i class="fa-solid fa-circle-check mr-1.5"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Bar Filter Tab & Pencarian -->
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-stretch md:items-center gap-3 mb-8">
            <div class="flex-1 bg-[#74dc7c] rounded-xl p-1.5 grid grid-cols-3 text-center font-bold text-xs md:text-sm shadow-sm">
                <a href="{{ route('admin.konsultasi', ['tab' => 'belum_ditangani', 'search' => $search]) }}"
                   class="py-2 rounded-lg transition {{ $tab === 'belum_ditangani' ? 'text-red-600 bg-white/40 shadow-xs' : 'text-gray-900 hover:bg-white/20' }}">
                    Belum ditangani ({{ $countBelum }})
                </a>
                <a href="{{ route('admin.konsultasi', ['tab' => 'berjalan', 'search' => $search]) }}"
                   class="py-2 rounded-lg transition {{ $tab === 'berjalan' ? 'text-red-600 bg-white/40 shadow-xs' : 'text-gray-900 hover:bg-white/20' }}">
                    Berjalan ({{ $countBerjalan }})
                </a>
                <a href="{{ route('admin.konsultasi', ['tab' => 'selesai', 'search' => $search]) }}"
                   class="py-2 rounded-lg transition {{ $tab === 'selesai' ? 'text-red-600 bg-white/40 shadow-xs' : 'text-gray-900 hover:bg-white/20' }}">
                    Selesai ({{ $countSelesai }})
                </a>
            </div>

            <form action="{{ route('admin.konsultasi') }}" method="GET" class="w-full md:w-56">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="cari nama user..."
                           class="w-full bg-[#cfe8d1] text-gray-800 placeholder:text-gray-600 text-xs font-medium pl-9 pr-3 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#065f2a]">
                </div>
            </form>
        </div>

        <!-- Daftar Kartu Konsultasi -->
        <div class="max-w-4xl mx-auto space-y-5">
            @forelse($listKonsultasi as $item)
                <div class="relative bg-[#d9efd2] border border-[#b8ddb0] rounded-2xl p-5 md:p-6 shadow-sm transition hover:shadow-md">

                    @if($tab === 'belum_ditangani')
                        <span class="absolute -top-2.5 -right-2.5 w-7 h-7 bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center shadow">
                            {{ $item->unread_count }}
                        </span>
                    @endif

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-full bg-white border border-gray-300 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-user text-gray-600 text-2xl"></i>
                        </div>

                        <div class="flex-1 min-w-0">
                            @if($tab === 'selesai')
                                <h3 class="text-base md:text-lg text-gray-900">
                                    <span class="font-extrabold">{{ $item->username }}</span> - {{ $item->topik }}
                                </h3>
                                <p class="text-xs md:text-sm text-gray-700 mt-0.5">
                                    status : {{ $item->raw_status === 'ditolak' ? 'Ditolak oleh Admin' : 'Ditutup oleh Admin' }}
                                </p>
                            @else
                                <h3 class="text-sm md:text-base font-extrabold text-gray-900">
                                    {{ $item->username }}
                                    <span class="text-xs font-normal text-gray-500 ml-1">({{ $item->email }})</span>
                                </h3>
                                <p class="text-xs md:text-sm text-gray-700 mt-1 line-clamp-2">
                                    {{ $item->preview }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($tab === 'belum_ditangani')
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <form action="{{ route('admin.konsultasi.status', $item->id_pemilik_tanaman) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="w-full py-2.5 bg-[#f48b84] hover:bg-red-500 text-white font-bold text-xs md:text-sm rounded-lg transition cursor-pointer shadow-xs">
                                    Tolak
                                </button>
                            </form>

                            <form action="{{ route('admin.konsultasi.status', $item->id_pemilik_tanaman) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="berjalan">
                                <button type="submit" class="w-full py-2.5 bg-[#084418] hover:bg-[#052e10] text-white font-bold text-xs md:text-sm rounded-lg transition cursor-pointer shadow-xs">
                                    Tangani
                                </button>
                            </form>
                        </div>
                    @elseif($tab === 'berjalan')
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <form action="{{ route('admin.konsultasi.status', $item->id_pemilik_tanaman) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="w-full py-2.5 bg-[#f48b84] hover:bg-red-500 text-white font-bold text-xs md:text-sm rounded-lg transition cursor-pointer shadow-xs">
                                    Selesai
                                </button>
                            </form>

                            <a href="{{ route('admin.konsultasi.chat', $item->id_pemilik_tanaman) }}"
                               class="w-full py-2.5 bg-[#084418] hover:bg-[#052e10] text-white font-bold text-xs md:text-sm rounded-lg transition text-center block shadow-xs">
                                Buka Chat
                            </a>
                        </div>
                    @else
                        <div class="flex justify-end mt-4">
                            <a href="{{ route('admin.konsultasi.chat', $item->id_pemilik_tanaman) }}"
                               class="px-6 py-2 bg-[#084418] hover:bg-[#052e10] text-white font-bold text-xs md:text-sm rounded-lg transition shadow-xs">
                                Lihat Detail
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-10 text-center text-gray-500">
                    <i class="fa-regular fa-comments text-4xl text-gray-300 mb-3"></i>
                    <p class="font-semibold text-sm">Belum ada konsultasi pada kategori ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        setInterval(function () {
            const searchInput = document.querySelector('input[name="search"]');
            if (!searchInput || document.activeElement !== searchInput) {
                window.location.reload();
            }
        }, 10000);
    </script>

</body>
</html>