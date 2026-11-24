<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Pengguna | UrbanFarming</title>

    <style>
        /* =====================================
           DASAR HALAMAN
        ===================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f3f6f1;
            color: #344536;
        }

        .monitoring-page {
            width: 100%;
            max-width: 1024px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 35px 38px;
        }

        /* =====================================
   HEADER MONITORING
===================================== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;

            padding: 35px 40px;
            margin-bottom: 28px;

            background: linear-gradient(110deg,
                    #2d7054,
                    #4db68c);

            border-radius: 22px;
            box-shadow: 0 8px 20px rgba(35, 90, 65, 0.15);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-button {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;

            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;

            font-size: 25px;
            text-decoration: none;
            transition: 0.2s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        .page-title {
            font-size: 27px;
            font-weight: 700;
            color: #ffffff;
        }

        .page-subtitle {
            font-size: 13px;
            color: #eaf5ee;
            margin-top: 6px;
        }

        .admin-label {
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* =====================================
           INTRODUCTION CARD
        ===================================== */
        .intro-section {
            background: #ffffff;
            border: 1px solid #e8ede5;
            border-radius: 14px;
            padding: 25px 27px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
        }

        .summary-card {
            width: 280px;
            min-height: 110px;
            background: #ffffff;
            border: 1px solid #e8ede5;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
            transition: .2s;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .summary-icon {
            width: 45px;
            height: 45px;
            border-radius: 13px;
            background: #e7f4eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .summary-info p {
            font-size: 12px;
            color: #849087;
            margin-bottom: 5px;
        }

        .summary-info h3 {
            font-size: 25px;
            color: #266210;
            font-weight: 700;
        }

        /* =====================================
           CONTENT CARD
        ===================================== */
        .content-card {
            background: #ffffff;
            border: 1px solid #e8ede5;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .content-header h2 {
            font-size: 18px;
            color: #285d32;
        }

        .content-header p {
            font-size: 12px;
            color: #849087;
            margin-top: 6px;
        }

        /* =====================================
           SEARCH
        ===================================== */
        .search-box {
            position: relative;
            width: 255px;
            flex-shrink: 0;
        }

        .search-box input {
            width: 100%;
            padding: 11px 13px 11px 38px;
            border: 1px solid #e2e9df;
            border-radius: 10px;
            outline: none;
            font-size: 12px;
            background: #fafcf9;
            transition: .2s;
        }

        .search-box input:focus {
            border-color: #266210;
            box-shadow: 0 0 0 3px rgba(38, 98, 16, .08);
            background: #ffffff;
        }

        .search-icon {
            position: absolute;
            left: 13px;
            top: 10px;
            color: #849087;
        }

        /* =====================================
           TABLE
        ===================================== */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e8ede5;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f3f6f1;
        }

        th {
            padding: 15px 14px;
            text-align: left;
            font-size: 11px;
            color: #526b56;
            font-weight: 700;
            border-bottom: 1px solid #e5ebe2;
        }

        td {
            padding: 15px 14px;
            border-bottom: 1px solid #edf0eb;
            font-size: 12px;
            color: #536057;
        }

        tbody tr {
            transition: .2s;
        }

        tbody tr:hover {
            background: #f7faf5;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =====================================
           USER IDENTITY
        ===================================== */
        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .user-avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: #e7f4eb;
            color: #266210;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 600;
            color: #285d32;
            font-size: 12px;
        }

        .user-email {
            color: #929b93;
            font-size: 11px;
            margin-top: 4px;
        }

        /* =====================================
           ROLE BADGE
        ===================================== */
        .role-badge {
            display: inline-block;
            padding: 6px 11px;
            background: #e7f4eb;
            color: #266210;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        /* =====================================
           DETAIL BUTTON
        ===================================== */
        .detail-button {
            display: inline-block;
            padding: 9px 14px;
            background: #266210;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            transition: .2s;
        }

        .detail-button:hover {
            background: #285d32;
            transform: translateY(-2px);
            box-shadow: 0 4px 9px rgba(38, 98, 16, .16);
        }

        /* =====================================
           EMPTY STATE
        ===================================== */
        .empty-state {
            text-align: center;
            padding: 45px 15px;
            color: #929b93;
        }

        .empty-icon {
            font-size: 35px;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-size: 15px;
            color: #285d32;
            margin-bottom: 7px;
        }

        .empty-state p {
            font-size: 12px;
        }

        .no-result {
            display: none;
            text-align: center;
            padding: 25px;
            font-size: 12px;
            color: #929b93;
        }

        /* =====================================
           FOOTER
        ===================================== */
        .page-footer {
            text-align: center;
            font-size: 11px;
            color: #929b93;
            margin-top: 24px;
        }

        /* =====================================
           RESPONSIVE DESKTOP 1024px
        ===================================== */
        @media screen and (min-width: 1024px) and (max-width: 1024px) {

            .monitoring-page {
                width: 1024px;
                max-width: 1024px;
                padding: 35px 38px;
                margin: 0 auto;
            }

            .page-header {
                width: 100%;
            }

            .intro-section,
            .summary-card,
            .content-card {
                width: 100%;
            }

            .content-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .search-box {
                width: 255px;
            }

            .table-wrapper {
                width: 100%;
                overflow-x: auto;
            }

            table {
                width: 100%;
                table-layout: fixed;
            }

            th,
            td {
                padding: 15px 14px;
            }
        }
    </style>
</head>

<body>

    <div class="monitoring-page">

        <!-- HEADER -->
        <div class="page-header">

            <div class="header-left">

                <a href="{{ route('admin.dashboard') }}" class="back-button">
                    &#8592;
                </a>

                <div>
                    <h1 class="page-title">Monitoring Pengguna</h1>

                    <p class="page-subtitle">
                        Pantau perkembangan tanaman setiap pengguna UrbanFarming.
                    </p>
                </div>

            </div>

            <div class="admin-label">
                Admin UrbanFarming
            </div>

        </div>


        <!-- SUMMARY -->
        <div class="summary-card">

            <div class="summary-icon">
                &#128101;
            </div>

            <div class="summary-info">

                <p>Total Pengguna Terdaftar</p>

                <h3>{{ $pengguna->count() }}</h3>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content-card">

            <div class="content-header">

                <div>

                    <h2>Daftar Pengguna</h2>

                    <p>
                        Pilih pengguna untuk melihat data dan perkembangan tanamannya.
                    </p>

                </div>

                <!-- SEARCH -->
                <div class="search-box">

                    <span class="search-icon">
                        &#128269;
                    </span>

                    <input
                        type="text"
                        id="searchUser"
                        placeholder="Cari nama pengguna..."
                        onkeyup="searchUser()">

                </div>

            </div>

            <!-- TABLE -->
            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 38%;">Informasi Pengguna</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 34%;">Aksi</th>
                        </tr>

                    </thead>

                    <tbody id="userTable">

                        @forelse ($pengguna as $index => $user)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>

                                <div class="user-info">

                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>

                                    <div>

                                        <div class="user-name">
                                            {{ $user->username }}
                                        </div>

                                        <div class="user-email">
                                            {{ $user->email ?? '-' }}
                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td>

                                <span class="role-badge">
                                    Pengguna
                                </span>

                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.monitoring.tanaman', $user->id_pemilik_tanaman) }}"
                                    class="detail-button">
                                    Lihat Tanaman &#8594;
                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        &#127793;
                                    </div>

                                    <h3>Belum Ada Pengguna</h3>

                                    <p>
                                        Data pengguna belum tersedia.
                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="no-result" id="noResult">
                    Pengguna yang dicari tidak ditemukan.
                </div>

            </div>

            <!-- FOOTER -->
            <div class="page-footer">
                Menampilkan {{ $pengguna->count() }} pengguna terdaftar.
            </div>

        </div>

    </div>

    <!-- JAVASCRIPT SEARCH -->
    <script>
        function searchUser() {

            const input = document.getElementById('searchUser');
            const filter = input.value.toLowerCase();

            const rows = document.querySelectorAll('#userTable tr');
            const noResult = document.getElementById('noResult');

            let visibleCount = 0;

            rows.forEach(function(row) {

                const text = row.textContent.toLowerCase();

                if (text.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }

            });

            noResult.style.display =
                visibleCount === 0 ? 'block' : 'none';
        }
    </script>

</body>

</html>