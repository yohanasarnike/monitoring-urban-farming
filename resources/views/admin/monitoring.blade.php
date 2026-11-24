<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Pengguna - Urban Farming</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('/img/bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #304238;
        }

        .container {
            width: 92%;
            max-width: 1500px;
            margin: 0 auto;
            padding: 16px 0 30px;
        }

        /* ================= HEADER ================= */

        .page-header {
            background: linear-gradient(110deg, #2d7559, #49b88e);
            border-radius: 22px;
            padding: 20px 30px;
            min-height: 112px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            margin-bottom: 18px;
            box-shadow: 0 8px 20px rgba(38, 111, 81, .10);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 17px;
            min-width: 0;
        }

        .back-button {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, .3);
            background: rgba(255, 255, 255, .17);
            color: white;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            text-decoration: none;
            transition: .2s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, .3);
        }

        .header-title h1 {
            font-size: 32px;
            font-weight: 500;
            line-height: 1.25;
            margin-bottom: 4px;
        }

        .header-title p {
            font-size: 13px;
            font-weight: 100;
            line-height: 1.5;
        }

        .admin-label {
            border: 1px solid rgba(255, 255, 255, .35);
            background: rgba(255, 255, 255, .15);
            padding: 9px 17px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ================= STATISTIK ================= */

        .monitoring-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
            max-width: 1050px;
            margin: 0 auto 18px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e8ece9;
            border-radius: 14px;
            padding: 12px 17px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 76px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .03);
        }

        .stat-info p {
            font-size: 12px;
            color: #818b84;
            margin-bottom: 3px;
        }

        .stat-info h2 {
            font-size: 21px;
            font-weight: 800;
            color: #304238;
        }

        .text-green {
            color: #16845c !important;
        }

        .text-red {
            color: #dc3156 !important;
        }

        .text-blue {
            color: #2580b4 !important;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .icon-green {
            background: #d8f8e9;
        }

        .icon-light-green {
            background: #e9f8ed;
        }

        .icon-red {
            background: #fff0f1;
        }

        .icon-blue {
            background: #eaf5ff;
        }

        /* ================= FILTER ================= */

        .filter-card {
            background: white;
            border: 1px solid #e8ece9;
            border-radius: 15px;
            padding: 18px 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .03);
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: 700;
            color: #4c5c51;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #dce4de;
            border-radius: 8px;
            outline: none;
            background: white;
            color: #536158;
            font-size: 12px;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #347d61;
            box-shadow: 0 0 0 3px rgba(52, 125, 97, .1);
        }

        .search-group {
            flex: 1;
            min-width: 180px;
        }

        .condition-group,
        .date-group {
            width: 160px;
            flex-shrink: 0;
        }

        .btn-filter {
            height: 42px;
            padding: 0 19px;
            border: none;
            border-radius: 8px;
            background: #286c53;
            color: white;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: #1e573f;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-wrapper input {
            width: 100%;
        }

        .suggestion-box {
            display: none;
            position: absolute;
            top: calc(100% + 7px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e1e9e3;
            border-radius: 11px;
            box-shadow: 0 8px 22px rgba(35, 75, 51, .12);
            z-index: 100;
            max-height: 260px;
            overflow-y: auto;
            padding: 6px;
        }

        .suggestion-box.show {
            display: block;
        }

        .suggestion-item {
            width: 100%;
            border: none;
            background: white;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px;
            border-radius: 8px;
            text-align: left;
            cursor: pointer;
            transition: .2s;
        }

        .suggestion-item:hover,
        .suggestion-item.active {
            background: #f0f8f2;
        }

        .suggestion-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #e2f4e9;
            color: #286c53;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
        }

        .suggestion-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .suggestion-name {
            font-size: 13px;
            font-weight: 800;
            color: #35483c;
        }

        .suggestion-email {
            font-size: 11px;
            color: #8a948d;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .suggestion-empty {
            padding: 14px 10px;
            text-align: center;
            color: #8a948d;
            font-size: 12px;
        }

        .user-section {
            background: white;
            border: 1px solid #e8ece9;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .03);
        }

        .section-heading {
            margin-bottom: 17px;
        }

        .section-heading h3 {
            font-size: 18px;
            font-weight: 800;
            color: #304238;
            margin-bottom: 5px;
        }

        .section-heading p {
            font-size: 12px;
            color: #879189;
        }

        .user-list {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .user-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 13px 15px;
            border: 1px solid #edf0ed;
            border-radius: 11px;
            transition: .2s;
        }

        .user-card:hover {
            border-color: #b8d9c5;
            background: #fbfefb;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e2f4e9;
            color: #286c53;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .user-details h4 {
            font-size: 14px;
            font-weight: 800;
            color: #35483c;
            margin-bottom: 3px;
        }

        .user-details p {
            font-size: 11px;
            color: #8a948d;
        }

        .btn-view {
            background: #e7f4eb;
            color: #286c53;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-view:hover {
            background: #286c53;
            color: white;
        }

        .empty-user {
            text-align: center;
            padding: 30px 15px;
            color: #8a948d;
            font-size: 13px;
        }

        /* ================= RESPONSIVE TABLET ================= */

        @media (max-width: 1024px) {
            .container {
                width: 94%;
                max-width: 850px;
                padding-top: 16px;
            }

            .page-header {
                padding: 19px 23px;
                min-height: 105px;
            }

            .header-left {
                gap: 14px;
            }

            .back-button {
                width: 44px;
                height: 44px;
                flex: 0 0 44px;
                font-size: 21px;
            }

            .header-title {
                flex: 1;
                min-width: 0;
            }

            .header-title h1 {
                font-size: 15px;
            }

            .header-title p {
                font-size: 12px;
            }

            .admin-label {
                font-size: 9px;
                padding: 8px 13px;
            }

            .monitoring-stats {
                max-width: 100%;
            }

            .filter-form {
                flex-wrap: wrap;
            }

            .search-group {
                flex-basis: 100%;
            }

            .condition-group,
            .date-group {
                flex: 1;
            }
        }

        /* ================= RESPONSIVE HP ================= */

        @media (max-width: 600px) {
            .container {
                width: 94%;
                padding-top: 12px;
            }

            .page-header {
                padding: 17px 14px;
                min-height: 90px;
                border-radius: 17px;
                gap: 10px;
            }

            .header-left {
                gap: 10px;
            }

            .back-button {
                width: 38px;
                height: 38px;
                flex: 0 0 38px;
                font-size: 18px;
                border-radius: 10px;
            }

            .header-title h1 {
                font-size: 20px;
            }

            .header-title p {
                font-size: 10px;
            }

            .monitoring-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
                margin-bottom: 14px;
            }

            .stat-card {
                padding: 9px 10px;
                min-height: 65px;
                border-radius: 11px;
            }

            .stat-info p {
                font-size: 9px;
            }

            .stat-info h2 {
                font-size: 18px;
            }

            .stat-icon {
                width: 30px;
                height: 30px;
                font-size: 13px;
                border-radius: 9px;
            }

            .filter-card {
                padding: 14px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-group,
            .condition-group,
            .date-group {
                width: 100%;
                flex: auto;
            }

            .btn-filter {
                width: 100%;
            }

            .user-section {
                padding: 15px;
            }

            .user-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .btn-view {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="page-header">

            <div class="header-left">

                <a href="{{ route('admin.dashboard') }}" class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div class="header-title">
                    <h1>Monitoring Pengguna</h1>
                    <p>Pantau perkembangan tanaman setiap pengguna UrbanFarming.</p>
                </div>

            </div>
        </div>

        {{-- ================= KARTU STATISTIK ================= --}}

        <div class="monitoring-stats">

            <div class="stat-card">
                <div class="stat-info">
                    <p>Total Data Dipantau</p>
                    <h2>{{ $totalDipantau ?? 0 }}</h2>
                </div>

                <div class="stat-icon icon-green">🌱</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p>Kondisi Sehat</p>
                    <h2 class="text-green">{{ $kondisiSehat ?? 0 }}</h2>
                </div>

                <div class="stat-icon icon-light-green">💚</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p>Terkena Hama / Perhatian</p>
                    <h2 class="text-red">{{ $terkenaHama ?? 0 }}</h2>
                </div>

                <div class="stat-icon icon-red">⚠️</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p>Perawatan Selesai</p>
                    <h2 class="text-blue">{{ $perawatanSelesai ?? 0 }}</h2>
                </div>

                <div class="stat-icon icon-blue">✔️</div>
            </div>

        </div>


        {{-- ================= PENCARIAN DAN FILTER ================= --}}

        <div class="filter-card">

            <form action="{{ url()->current() }}" method="GET" class="filter-form" id="filterForm">

                <div class="filter-group search-group">

                    <label for="search">Cari Tanaman / Pengguna</label>

                    <div class="search-wrapper">

                        <input
                            type="text"
                            id="search"
                            placeholder="Ketik nama pengguna..."
                            value=""
                            autocomplete="off"
                            aria-label="Cari nama atau email pengguna"
                            aria-autocomplete="list"
                            aria-expanded="false"
                            aria-controls="suggestionBox">

                        <div
                            class="suggestion-box"
                            id="suggestionBox"
                            role="listbox">
                        </div>

                    </div>

                </div>


                <div class="filter-group condition-group">

                    <label for="kondisi">Kondisi</label>

                    <select name="kondisi" id="kondisi">

                        <option value="">Semua Kondisi</option>

                        <option value="Sehat" {{ request('kondisi') == 'Sehat' ? 'selected' : '' }}>
                            Sehat
                        </option>

                        <option value="Perhatian" {{ request('kondisi') == 'Perhatian' ? 'selected' : '' }}>
                            Perhatian
                        </option>

                        <option value="Terkena Hama" {{ request('kondisi') == 'Terkena Hama' ? 'selected' : '' }}>
                            Terkena Hama
                        </option>

                    </select>

                </div>


                <div class="filter-group date-group">

                    <label for="tanggal">Tanggal</label>

                    <input
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        value="{{ request('tanggal') }}">

                </div>


                <button type="submit" class="btn-filter">
                    ▼ Filter
                </button>

            </form>

        </div>


        {{-- ================= DAFTAR PENGGUNA ================= --}}

        <div class="user-section">

            <div class="section-heading">

                <h3>Daftar Pengguna</h3>

                <p>
                    Pilih pengguna untuk melihat perkembangan dan kondisi tanamannya.
                </p>

            </div>


            <div class="user-list" id="userList">

                @forelse ($pengguna as $user)

                <div
                    class="user-card"
                    data-name="{{ strtolower($user->nama ?? $user->username ?? 'Pengguna') }}"
                    data-email="{{ strtolower($user->email ?? '') }}">

                    <div class="user-info">

                        <div class="user-avatar">
                            {{ strtoupper(substr($user->nama ?? $user->username ?? 'U', 0, 1)) }}
                        </div>

                        <div class="user-details">

                            <h4>
                                {{ $user->nama ?? $user->username ?? 'Pengguna' }}
                            </h4>

                            <p>
                                {{ $user->email ?? 'Pengguna Urban Farming' }}
                            </p>

                        </div>

                    </div>

                    <a
                        href="{{ route('admin.monitoring.tanaman', $user->id_pemilik_tanaman) }}"
                        class="btn-view">

                        Lihat Tanaman →

                    </a>

                </div>

                @empty

                <div class="empty-user">
                    Belum ada pengguna yang terdaftar.
                </div>

                @endforelse

            </div>


            <div class="empty-user" id="searchEmpty" style="display: none;">
                Pengguna tidak ditemukan. Coba gunakan kata kunci lain.
            </div>

        </div>

    </div>


    {{-- ================= JAVASCRIPT AUTOCOMPLETE ================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('search');
            const suggestionBox = document.getElementById('suggestionBox');
            const userCards = Array.from(document.querySelectorAll('.user-card'));
            const searchEmpty = document.getElementById('searchEmpty');

            let activeIndex = -1;

            function normalizeText(text) {
                return (text || '').toLowerCase().trim();
            }

            function getMatchingUsers(keyword) {

                return userCards.filter(function(card) {

                    const name = normalizeText(card.dataset.name);
                    const email = normalizeText(card.dataset.email);

                    return name.includes(keyword) || email.includes(keyword);

                });

            }

            function filterUserList(keyword) {

                const matchingUsers = getMatchingUsers(keyword);

                userCards.forEach(function(card) {

                    const name = normalizeText(card.dataset.name);
                    const email = normalizeText(card.dataset.email);

                    const matches =
                        keyword === '' ||
                        name.includes(keyword) ||
                        email.includes(keyword);

                    card.style.display = matches ? 'flex' : 'none';

                });

                if (searchEmpty) {

                    searchEmpty.style.display =
                        keyword !== '' && matchingUsers.length === 0 ?
                        'block' :
                        'none';

                }

            }

            function hideSuggestions() {

                suggestionBox.classList.remove('show');
                suggestionBox.innerHTML = '';

                searchInput.setAttribute('aria-expanded', 'false');

                activeIndex = -1;

            }

            function showSuggestions(keyword) {

                suggestionBox.innerHTML = '';

                activeIndex = -1;

                if (keyword === '') {

                    hideSuggestions();

                    return;

                }

                const matchingUsers = getMatchingUsers(keyword).slice(0, 6);

                if (matchingUsers.length === 0) {

                    const emptyMessage = document.createElement('div');

                    emptyMessage.className = 'suggestion-empty';
                    emptyMessage.textContent = 'Pengguna tidak ditemukan.';

                    suggestionBox.appendChild(emptyMessage);

                    suggestionBox.classList.add('show');

                    searchInput.setAttribute('aria-expanded', 'true');

                    return;

                }

                matchingUsers.forEach(function(card) {

                    const name =
                        card.querySelector('.user-details h4')?.textContent.trim() || 'Pengguna';

                    const email =
                        card.querySelector('.user-details p')?.textContent.trim() || '';

                    const initial = name.charAt(0).toUpperCase();

                    const button = document.createElement('button');

                    button.type = 'button';
                    button.className = 'suggestion-item';
                    button.setAttribute('role', 'option');
                    button.setAttribute('aria-selected', 'false');

                    const avatar = document.createElement('div');
                    avatar.className = 'suggestion-avatar';
                    avatar.textContent = initial;

                    const details = document.createElement('div');
                    details.className = 'suggestion-details';

                    const nameElement = document.createElement('span');
                    nameElement.className = 'suggestion-name';
                    nameElement.textContent = name;

                    const emailElement = document.createElement('span');
                    emailElement.className = 'suggestion-email';
                    emailElement.textContent = email;

                    details.appendChild(nameElement);
                    details.appendChild(emailElement);

                    button.appendChild(avatar);
                    button.appendChild(details);

                    button.addEventListener('click', function() {
                        selectSuggestion(card, name);
                    });

                    suggestionBox.appendChild(button);

                });

                suggestionBox.classList.add('show');

                searchInput.setAttribute('aria-expanded', 'true');

            }

            function selectSuggestion(card, name) {

                searchInput.value = name;

                userCards.forEach(function(userCard) {

                    userCard.style.display =
                        userCard === card ? 'flex' : 'none';

                });

                if (searchEmpty) {
                    searchEmpty.style.display = 'none';
                }

                hideSuggestions();

                searchInput.focus();

            }

            searchInput.addEventListener('input', function() {

                const keyword = normalizeText(this.value);

                filterUserList(keyword);

                showSuggestions(keyword);

            });

            searchInput.addEventListener('focus', function() {

                const keyword = normalizeText(this.value);

                if (keyword !== '') {
                    showSuggestions(keyword);
                }

            });

            searchInput.addEventListener('keydown', function(event) {

                const items =
                    suggestionBox.querySelectorAll('.suggestion-item');

                if (event.key === 'Escape') {

                    hideSuggestions();

                    return;

                }

                if (!suggestionBox.classList.contains('show') || items.length === 0) {
                    return;
                }

                if (event.key === 'ArrowDown') {

                    event.preventDefault();

                    activeIndex = (activeIndex + 1) % items.length;

                    updateActiveSuggestion(items);

                }

                if (event.key === 'ArrowUp') {

                    event.preventDefault();

                    activeIndex =
                        activeIndex <= 0 ?
                        items.length - 1 :
                        activeIndex - 1;

                    updateActiveSuggestion(items);

                }

                if (event.key === 'Enter' && activeIndex >= 0) {

                    event.preventDefault();

                    items[activeIndex].click();

                }

            });

            function updateActiveSuggestion(items) {

                items.forEach(function(item, index) {

                    const isActive = index === activeIndex;

                    item.classList.toggle('active', isActive);

                    item.setAttribute(
                        'aria-selected',
                        isActive ? 'true' : 'false'
                    );

                });

                if (items[activeIndex]) {

                    items[activeIndex].scrollIntoView({
                        block: 'nearest'
                    });

                }

            }

            document.addEventListener('click', function(event) {

                if (!event.target.closest('.search-wrapper')) {
                    hideSuggestions();
                }

            });

            searchInput.value = '';

            filterUserList('');

            hideSuggestions();

        });
    </script>

</body>

</html>