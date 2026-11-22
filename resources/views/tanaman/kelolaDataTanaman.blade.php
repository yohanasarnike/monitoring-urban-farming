<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Tanaman - Admin Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- TOP NAVBAR -->
    <header class="bg-[#0b3b24] text-white px-6 md:px-10 h-16 flex items-center justify-between shadow-md">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 font-bold text-base tracking-wide hover:text-emerald-200 transition">
            <span class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-sm border border-green-400">🌱</span>
            <span>Urban Farming</span>
        </a>

        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="text-emerald-100 hover:text-white transition">Dashboard</a>
            <span class="text-emerald-200 font-medium">Hy, Admin</span>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-6 md:p-10 max-w-6xl w-full mx-auto">

        <!-- Judul Halaman -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-seedling text-2xl text-[#1b4332]"></i>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Data Kriteria Tanaman</h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-[#2d6a4f] hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <!-- Notifikasi Sukses / Validasi -->
        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Baris Tambah Data & Pencarian -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
            <button type="button" onclick="bukaModalTambah()"
                class="inline-flex items-center gap-2 bg-[#2d6a4f] hover:bg-[#1b4332] text-white text-sm font-semibold px-4 py-2.5 rounded-md shadow-sm transition cursor-pointer w-fit">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Tambah Data</span>
            </button>

            <form action="{{ route('admin.kelola-data') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama tanaman..."
                    class="border border-gray-300 rounded-md px-3.5 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#2d6a4f]">
                <button type="submit"
                    class="bg-[#2d6a4f] hover:bg-[#1b4332] text-white text-sm font-medium px-4 py-2 rounded-md transition cursor-pointer">
                    Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('admin.kelola-data') }}"
                        class="border border-gray-300 bg-white hover:bg-gray-100 text-gray-600 text-sm px-3 py-2 rounded-md transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Data dari Database -->
        <div class="overflow-x-auto border border-gray-200 rounded-md shadow-sm bg-white">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-[#52b788] text-white font-semibold border-b border-gray-200">
                        <th class="py-3 px-4 w-14 text-center">No</th>
                        <th class="py-3 px-4">Nama Tanaman</th>
                        <th class="py-3 px-4 text-center">pH Ideal</th>
                        <th class="py-3 px-4 text-center">Suhu Ideal (°C)</th>
                        <th class="py-3 px-4 text-center">Usia Panen (Hari)</th>
                        <th class="py-3 px-4 text-center w-40">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700 bg-white">
                    @forelse($dataTanaman as $index => $item)
                        <tr class="hover:bg-emerald-50/40 transition">
                            <td class="py-3 px-4 text-center font-medium text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->nama_tanaman }}</td>
                            <td class="py-3 px-4 text-center">{{ $item->pH_min }} - {{ $item->pH_max }}</td>
                            <td class="py-3 px-4 text-center">{{ $item->suhu_min }} - {{ $item->suhu_max }}</td>
                            <td class="py-3 px-4 text-center">{{ $item->usia_panen ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <button type="button"
                                        onclick='bukaModalEdit(@json($item))'
                                        class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3 py-1.5 rounded transition cursor-pointer">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.kelola-data.destroy', $item->id_tanaman) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama_tanaman }} dari database?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold px-3 py-1.5 rounded transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                Belum ada data di tabel <strong>kriteria_tanaman</strong>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <!-- MODAL TAMBAH / EDIT -->
    <div id="modalForm" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center pb-3 border-b mb-4">
                <h3 id="modalTitle" class="text-lg font-bold text-[#1b4332]">Tambah Data Tanaman</h3>
                <button type="button" onclick="tutupModal()" class="text-gray-400 hover:text-gray-700 text-xl cursor-pointer">&times;</button>
            </div>

            <form id="formTanaman" method="POST" action="{{ route('admin.kelola-data.store') }}">
                @csrf
                <div id="methodField"></div>

                <div class="space-y-3 text-sm">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Tanaman</label>
                        <input type="text" name="nama_tanaman" id="nama_tanaman" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                            placeholder="Contoh: Kangkung">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Usia Panen (Hari)</label>
                        <input type="number" name="usia_panen" id="usia_panen"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                            placeholder="Contoh: 30">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">pH Min</label>
                            <input type="number" step="0.01" name="pH_min" id="pH_min"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                                placeholder="5.50">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">pH Max</label>
                            <input type="number" step="0.01" name="pH_max" id="pH_max"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                                placeholder="6.50">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Suhu Min (°C)</label>
                            <input type="number" step="0.01" name="suhu_min" id="suhu_min"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                                placeholder="18.00">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Suhu Max (°C)</label>
                            <input type="number" step="0.01" name="suhu_max" id="suhu_max"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#2d6a4f]"
                                placeholder="30.00">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6 pt-3 border-t">
                    <button type="button" onclick="tutupModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm font-medium hover:bg-gray-50 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-[#2d6a4f] hover:bg-[#1b4332] text-white text-sm font-semibold cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalForm');
        const form = document.getElementById('formTanaman');
        const methodField = document.getElementById('methodField');
        const modalTitle = document.getElementById('modalTitle');

        function bukaModalTambah() {
            modalTitle.textContent = 'Tambah Data Tanaman';
            form.action = "{{ route('admin.kelola-data.store') }}";
            methodField.innerHTML = '';
            document.getElementById('nama_tanaman').value = '';
            document.getElementById('usia_panen').value = '';
            document.getElementById('pH_min').value = '';
            document.getElementById('pH_max').value = '';
            document.getElementById('suhu_min').value = '';
            document.getElementById('suhu_max').value = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function bukaModalEdit(item) {
            modalTitle.textContent = 'Edit Data Tanaman';
            form.action = "{{ url('/admin/kelola-data') }}/" + item.id_tanaman;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('nama_tanaman').value = item.nama_tanaman ?? '';
            document.getElementById('usia_panen').value = item.usia_panen ?? '';
            document.getElementById('pH_min').value = item.pH_min ?? '';
            document.getElementById('pH_max').value = item.pH_max ?? '';
            document.getElementById('suhu_min').value = item.suhu_min ?? '';
            document.getElementById('suhu_max').value = item.suhu_max ?? '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function tutupModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>