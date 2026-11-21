<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Tanaman - Urban Farming</title>
    <link rel="stylesheet" href="{{ asset('css/inputTanaman.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Navbar Atas Penuh -->
     @if(isset($fromDashboard) && $fromDashboard)
    <nav class="top-navbar">
        <div class="nav-brand">Sistem Monitoring Urban Farming</div>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="btn-nav-back">Kembali ke Dashboard</a>
        </div>
    </nav>
    @endif

    <!-- Layout Utama Dua Kolom (Split Screen) -->
    <div class="split-container">
        
        <!-- Sisi Kiri: Banner & Foto Tanaman Estetik -->
        <div class="split-left">
            <div class="overlay-content">
                <span class="badge-sub">Formulir Pertanian</span>
                <h1 class="left-title">Masukkan<br>Data Tanaman</h1>
                <p class="left-desc">
                    Catat informasi awal tanaman dengan akurat untuk menghasilkan jadwal perawatan otomatis yang terstruktur dan berkelanjutan. 🌱
                </p>
            </div>
        </div>

        <!-- Sisi Kanan: Kotak Form Input -->
        <div class="split-right">
            <div class="form-card-box-modern">
                <h2 class="form-main-title">Input Data Tanaman</h2>
                
                <form action="{{ url('/tanaman/tambah') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="jenis_bibit">Jenis Bibit</label>
                        <select name="jenis_bibit" id="jenis_bibit" class="form-control" required>
                            <option value="">-- Pilih Jenis Tanaman --</option>
                            @foreach($daftarKriteria as $kriteria)
                            <option value="{{ $kriteria->nama_tanaman }}" {{ old('jenis_bibit') == $kriteria->nama_tanaman ? 'selected' : '' }}>
                                {{ $kriteria->nama_tanaman }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row-group">
                        <div class="col-half">
                            <label>Tanggal Tanam</label>
                            <input type="date" name="tanggal_tanam" class="form-control" required>
                        </div>
                        <div class="col-half">
                            <label>Suhu (°C)</label>
                            <input type="text" name="suhu" class="form-control" placeholder="contoh: 25" required>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="col-half">
                            <label>pH Tanah</label>
                            <input type="text" name="ph_tanah" class="form-control" placeholder="contoh: 6.5" required>
                        </div>
                        <div class="col-half">
                            <label>Kelembapan (%)</label>
                            <input type="text" name="kelembapan" class="form-control" placeholder="contoh: 80" required>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="col-half">
                            <label>Jenis Lahan</label>
                            <input type="text" name="jenis_lahan" class="form-control" placeholder="contoh: Hidroponik" required>
                        </div>
                        <div class="col-half">
                            <label>Lokasi Penanaman</label>
                            <input type="text" name="lokasi_tanam" class="form-control" placeholder="contoh: Rooftop" required>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="col-half">
                            <label>Tinggi Tanaman (cm)</label>
                            <input type="text" name="tinggi_tanaman" class="form-control" placeholder="Contoh: 12" required>
                        </div>
                        <div class="col-half">
                            <label>Jenis Pupuk</label>
                            <input type="text" name="jenis_pupuk" class="form-control" placeholder="Contoh: Organik" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kondisi Tanaman</label>
                        <input type="text" name="kondisi_tanaman" class="form-control" placeholder="contoh: Sehat" required>
                    </div>

                    <button type="submit" class="btn-submit">Simpan Data Tanaman</button>
                </form>

                @if ($errors->any())
                <div class="alert-error">
                    <strong>Periksa inputan berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

    </div>

</body>

</html>