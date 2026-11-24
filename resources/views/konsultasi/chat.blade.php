<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Konsultasi - Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white w-screen h-screen m-0 overflow-hidden flex flex-col justify-between p-6 md:p-10 text-gray-800">

    @php
        $userFoto = Auth::user()->foto ?? Auth::user()->avatar ?? null;
    @endphp

    <!-- Header Chat Atas -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <div class="flex items-center gap-4">
            <a href="/dashboard" class="text-emerald-800 hover:text-emerald-950 transition">
                <i class="fa-solid fa-chevron-left text-2xl"></i>
            </a>
            <!-- Avatar Header: Ikon Tanaman -->
            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center shadow-sm border border-emerald-200 shrink-0">
                <i class="fa-solid fa-seedling text-emerald-700 text-2xl"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg md:text-2xl text-emerald-900 leading-tight">Konsultasi Urban Farming</h2>
                <p class="text-xs md:text-sm text-emerald-600 font-medium flex items-center gap-1.5">
                    <span>Terhubung dengan Pakar Pertanian</span>
                    <span class="text-gray-300">•</span>
                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-xs border border-emerald-200">
                        <i class="fa-solid fa-lock text-[10px]"></i> Terenkripsi
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Area Chat Container -->
    <div id="chatContainer" class="flex-1 overflow-y-auto space-y-6 my-6 pr-2 md:pr-4">
        
        <!-- Pesan Sambutan Pakar Default (Avatar Tanaman) -->
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                <i class="fa-solid fa-seedling text-emerald-700 text-lg"></i>
            </div>
            <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md">
                Selamat datang di Konsultasi Urban Farming, {{ Auth::user()->nama ?? Auth::user()->username }}! Silakan beri tahu kendala tanaman Anda, Admin/Pakar kami akan segera membalas.
            </div>
        </div>

        <!-- Render Pesan Lama Khusus Milik Akun Ini dari Database -->
        @if(isset($messages) && count($messages) > 0)
            @foreach($messages as $msg)
                @if(!empty($msg->pertanyaan_konsultasi))
                    <!-- Bubble Chat User (Kanan - Avatar Ikon Orang / Foto Profil) -->
                    <div class="flex items-start justify-end gap-3">
                        <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md break-words">
                            {{ $msg->pertanyaan_konsultasi }}
                        </div>
                        @if($userFoto)
                            <img src="{{ asset('storage/' . $userFoto) }}" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md border border-gray-200" alt="User">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                                <i class="fa-solid fa-user text-gray-600 text-lg"></i>
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($msg->jawaban_konsultasi))
                    <!-- Bubble Balasan Admin (Kiri - Avatar Ikon Tanaman) -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                            <i class="fa-solid fa-seedling text-emerald-700 text-lg"></i>
                        </div>
                        <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md break-words">
                            {{ $msg->jawaban_konsultasi }}
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

    </div>

    <!-- Form Input Chat Bar + Pop-up Emoji Picker -->
    <div class="relative pt-4 border-t border-gray-100">
        <!-- Pop-up Panel Emoji (Tersembunyi secara default) -->
        <div id="emojiPicker" class="hidden absolute bottom-20 left-0 bg-white border border-emerald-200 rounded-2xl shadow-xl p-3 z-50 w-72">
            <div class="text-xs font-semibold text-emerald-800 mb-2 px-1">Pilih Emoji</div>
            <div class="grid grid-cols-6 gap-1.5 text-xl text-center">
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌱</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌿</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🍅</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🥬</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌶️</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">💧</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">☀️</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🐛</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🍂</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">😊</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">😢</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🙏</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">👍</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🤔</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">✨</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌻</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🪴</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">✅</button>
            </div>
        </div>

        <form id="chatForm" action="javascript:void(0);" class="flex items-center gap-4">
            <button type="button" id="emojiToggleBtn" title="Sisipkan Emoji" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition shrink-0 cursor-pointer">
                <i class="fa-regular fa-face-smile"></i>
            </button>

            <div class="flex-1 bg-emerald-50/60 backdrop-blur-md border border-emerald-200/80 rounded-full flex items-center px-6 py-4 shadow-sm hover:shadow-md transition-all">
                <input type="text" id="messageInput" name="message" placeholder="Tulis kendala tanamanmu di sini..." class="w-full text-sm md:text-base text-gray-800 bg-transparent focus:outline-none placeholder:text-gray-400 font-medium" autocomplete="off" required>
            </div>

            <button type="submit" id="sendBtn" title="Kirim Pesan" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition cursor-pointer shrink-0">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const chatContainer = document.getElementById('chatContainer');
        const emojiToggleBtn = document.getElementById('emojiToggleBtn');
        const emojiPicker = document.getElementById('emojiPicker');

        // Scroll otomatis ke chat paling bawah
        chatContainer.scrollTop = chatContainer.scrollHeight;

        // Toggle buka/tutup panel emoji
        emojiToggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            emojiPicker.classList.toggle('hidden');
        });

        // Klik emoji untuk menyisipkan ke input pesan
        document.querySelectorAll('.emoji-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                messageInput.value += this.textContent;
                messageInput.focus();
            });
        });

        // Tutup panel emoji jika klik di luar area picker
        document.addEventListener('click', function (e) {
            if (!emojiPicker.contains(e.target) && !emojiToggleBtn.contains(e.target)) {
                emojiPicker.classList.add('hidden');
            }
        });

        // Fungsi aman untuk mencegah HTML injection pada tampilan chat
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Kirim pesan via AJAX
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const messageText = messageInput.value.trim();
                if (!messageText) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                emojiPicker.classList.add('hidden');

                fetch("/konsultasi/send", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ message: messageText })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const userAvatarHtml = @if($userFoto)
                            `<img src="{{ asset('storage/' . $userFoto) }}" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md border border-gray-200" alt="User">`
                        @else
                            `<div class="w-10 h-10 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                                <i class="fa-solid fa-user text-gray-600 text-lg"></i>
                            </div>`
                        @endif;

                        const userBubble = `
                            <div class="flex items-start justify-end gap-3">
                                <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md break-words">
                                    ${escapeHtml(data.data.message)}
                                </div>
                                ${userAvatarHtml}
                            </div>
                        `;
                        chatContainer.insertAdjacentHTML('beforeend', userBubble);
                        messageInput.value = '';
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    } else {
                        alert('Gagal menyimpan pesan: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => console.error('Error AJAX:', error));
            });
        }
    });
    </script>

</body>
</html>