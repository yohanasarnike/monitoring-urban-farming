<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Monitoring - Urban Farming</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            color: #244f3c;
        }

        .navbar {
            min-height: 75px;
            background: #28694f;
            color: white;
            padding: 15px 4%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 23px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .container {
            width: 85%;
            max-width: 1000px;
            margin: 25px auto;
        }

        .back {
            display: inline-block;
            color: #347b55;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Identitas Tanaman */
        .plant-heading {
            text-align: center;
            margin-bottom: 15px;
        }

        .plant-avatar {
            width: 65px;
            height: 65px;
            background: #e7f4eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #347b55;
            font-size: 29px;
            margin: auto auto 7px;
        }

        .plant-heading h2 {
            color: #111;
            font-size: 18px;
        }

        .plant-heading p {
            color: #777;
            font-size: 12px;
        }

        /* Kartu Informasi Tanaman */
        .plant-information {
            max-width: 650px;
            min-height: 115px;
            margin: 0 auto 12px;
            padding: 15px 20px;
            background: #c9e9a9;
            border: 1px solid #91aa7e;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .plant-photo {
            width: 85px;
            height: 85px;
            border-radius: 10px;
            background: #e7f4eb;
            color: #397b5c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            flex-shrink: 0;
        }

        .plant-details {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #416b35;
            font-size: 12px;
            font-weight: 600;
        }

        .detail-row i {
            font-size: 15px;
            width: 16px;
        }

        .detail-row small {
            display: block;
            font-size: 9px;
            font-weight: 400;
            color: #66834d;
        }

        /* Tabel Perkembangan */
        .table-title {
            text-align: center;
            font-size: 19px;
            color: #294e70;
            margin: 8px 0;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
            color: #111;
        }

        thead {
            background: #65bd6c;
            color: white;
        }

        th {
            padding: 9px;
            font-weight: 600;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #aaa;
        }

        tbody tr:hover {
            background: #f4faf3;
        }

        .empty {
            color: #888;
            padding: 20px;
        }

        @media (max-width: 1024px) {
            .container {
                width: 90%;
            }

            .plant-information {
                max-width: 600px;
            }
        }

        @media (max-width: 600px) {
            .navbar h2 {
                font-size: 17px;
            }

            .plant-information {
                padding: 12px;
                gap: 12px;
            }

            .plant-photo {
                width: 65px;
                height: 65px;
                font-size: 28px;
            }

            table {
                min-width: 450px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>🌱 Monitoring Urban Farming</h2>

        <a href="{{ route('admin.dashboard') }}">
            <i class="fa-solid fa-house"></i> Beranda
        </a>
    </div>

    <div class="container">

        <a href="{{ route('admin.monitoring.tanaman', $data->id_pemilik_tanaman) }}"
            class="back">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Tanaman
        </a>

        <!-- Identitas Tanaman -->
        <div class="plant-heading">

            <div class="plant-avatar">
                <i class="fa-solid fa-seedling"></i>
            </div>

            <h2>{{ $data->jenis_bibit }}</h2>

            <p>Pemilik: {{ $data->username }}</p>

        </div>

        <!-- Informasi Tanaman -->
        <div class="plant-information">

            <div class="plant-photo">
                <i class="fa-solid fa-leaf"></i>
            </div>

            <div class="plant-details">

                <div class="detail-row">
                    <i class="fa-solid fa-seedling"></i>

                    <div>
                        {{ $data->jenis_bibit }}
                        <small>Jenis Tanaman</small>
                    </div>
                </div>

                <div class="detail-row">
                    <i class="fa-regular fa-calendar"></i>

                    <div>
                        {{ $data->tanggal_tanam
                            ? \Carbon\Carbon::parse($data->tanggal_tanam)->format('d M Y')
                            : '-' }}
                        <small>Tanggal Tanam</small>
                    </div>
                </div>

                <div class="detail-row">
                    <i class="fa-solid fa-clock"></i>

                    <div>
                        {{ $umurTanaman }} Hari
                        <small>Umur Tanaman</small>
                    </div>
                </div>

            </div>

        </div>

        <!-- Tabel Perkembangan -->
        <h2 class="table-title">Tabel Perkembangan</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Minggu</th>
                        <th>Tinggi Tanaman</th>
                        <th>Tanggal Pengukuran</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($perkembangan as $item)

                    <tr>
                        <td>Minggu {{ $item->minggu }}</td>

                        <td>
                            {{ number_format((float) $item->tinggi, 1, ',', '.') }} cm
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="3" class="empty">
                            Belum ada data perkembangan tanaman.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>