<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Tanaman</title>
    <link rel="stylesheet" href="{{ asset('css/inputTanaman.css') }}">
</head>

<body>

    <div class="main-container">
        <div class="banner-header">
            <h1 class="banner-title">Masukan<br>Data Tanaman Kamu</h1>
        </div>

        <div class="form-content">
            <form action="{{ url('/tanaman/tambah') }}" method="POST">
                @csrf

                <div class="form-card-box">
                    <div class="form-group">
                        <label>Jenis Bibit</label>
                        <input type="text" name="jenis_bibit" class="form-control" placeholder="contoh: Selada" required>
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
                </div>

                <div class="form-card-box">
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
                </div>

                <button type="submit" class="btn-submit">Simpan Data</button>
            </form>

            @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <strong>Data gagal disimpan! Periksa inputan berikut:</strong>
                <ul style="margin-top: 8px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

</body>

</html>