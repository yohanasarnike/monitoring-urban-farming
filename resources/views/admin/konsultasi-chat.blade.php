<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Balas Konsultasi {{ $pengguna->username }} - Admin Urban Farming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white w-screen h-screen m-0 overflow-hidden flex flex-col justify-between p-6 md:p-10 text-gray-800">

    <!-- Header Ruang Chat Admin -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.konsultasi', ['tab' => $sessionStatus === 'selesai' ? 'selesai' : 'berjalan']) }}"
               class="text-emerald-800 hover:text-emerald-950 transition">
                <i class="fa-solid fa-chevron-left text-2xl"></i>
            </a>
            <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center shrink-0 shadow-sm">
                <i class="fa-solid fa-user text-gray-600 text-2xl"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg md:text-2xl text-emerald-900 leading-tight">
                    {{ $pengguna->username }}
                </h2>
                <p class="text-xs md:text-sm text-emerald-600 font-medium flex items-center gap-2">
                    <span>{{ $pengguna->email }}</span>
                    <span class="text-gray-300">•</span>
                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-xs border border-emerald-200">
                        <i class="fa-solid fa-lock text-[10px]"></i> Terenkripsi AES-256
                    </span>
                </p>
            </div>
        </div>

        @if($sessionStatus !== 'selesai' && $sessionStatus !== 'ditolak')
            <form action="{{ route('admin.konsultasi.status', $pengguna->id_pemilik_tanaman) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="selesai">
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs md:text-sm font-bold rounded-xl transition cursor-pointer shadow-sm">
                    <i class="fa-solid fa-circle-check mr-1"></i> Selesai Konsultasi
                </button>
            </form>
        @else
            <span class="px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-full border border-gray-300">
                Sesi Ditutup
            </span>
        @endif
    </div>

    <!-- Area Chat Container -->
    <div id="chatContainer" class="flex-1 overflow-y-auto space-y-6 my-6 pr-2 md:pr-4">
        @forelse($messages as $msg)
            @if(!empty($msg->pertanyaan_konsultasi))
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                        <i class="fa-solid fa-user text-gray-600 text-lg"></i>
                    </div>
                    <div class="bg-gray-100 text-gray-900 border border-gray-200 p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-sm break-words">
                        {{ $msg->pertanyaan_konsultasi }}
                    </div>
                </div>
            @endif

            @if(!empty($msg->jawaban_konsultasi))
                <div class="flex items-start justify-end gap-3">
                    <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md break-words">
                        {{ $msg->jawaban_konsultasi }}
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                        <i class="fa-solid fa-seedling text-emerald-700 text-lg"></i>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-center text-sm text-gray-400 italic my-10">Belum ada pesan dalam sesi konsultasi ini.</p>
        @endforelse
    </div>

    <!-- Form Input Balasan Admin + Emoji Picker -->
    <div class="relative pt-4 border-t border-gray-100">
        <div id="emojiPicker" class="hidden absolute bottom-20 left-0 bg-white border border-emerald-200 rounded-2xl shadow-xl p-3 z-50 w-72">
            <div class="text-xs font-semibold text-emerald-800 mb-2 px-1">Pilih Emoji</div>
            <div class="grid grid-cols-6 gap-1.5 text-xl text-center">
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌱</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🌿</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🍅</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">💧</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">☀️</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🐛</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">😊</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🙏</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">👍</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">✅</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">🪴</button>
                <button type="button" class="emoji-btn hover:bg-emerald-50 rounded-lg p-1 transition">✨</button>
            </div>
        </div>

        <form id="adminChatForm" action="javascript:void(0);" class="flex items-center gap-4">
            <button type="button" id="emojiToggleBtn" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition shrink-0 cursor-pointer">
                <i class="fa-regular fa-face-smile"></i>
            </button>

            <div class="flex-1 bg-emerald-50/60 backdrop-blur-md border border-emerald-200/80 rounded-full flex items-center px-6 py-4 shadow-sm">
                <input type="text"
                       id="replyInput"
                       placeholder="Tulis saran atau balasan untuk {{ $pengguna->username }}..."
                       class="w-full text-sm md:text-base text-gray-800 bg-transparent focus:outline-none placeholder:text-gray-400 font-medium"
                       autocomplete="off"
                       required>
            </div>

            <button type="submit" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition cursor-pointer shrink-0">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatForm = document.getElementById('adminChatForm');
        const replyInput = document.getElementById('replyInput');
        const chatContainer = document.getElementById('chatContainer');
        const emojiToggleBtn = document.getElementById('emojiToggleBtn');
        const emojiPicker = document.getElementById('emojiPicker');
        const userId = "{{ $pengguna->id_pemilik_tanaman }}";
        let lastRenderHash = "";

        chatContainer.scrollTop = chatContainer.scrollHeight;

        emojiToggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            emojiPicker.classList.toggle('hidden');
        });

        document.querySelectorAll('.emoji-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                replyInput.value += this.textContent;
                replyInput.focus();
            });
        });

        document.addEventListener('click', function (e) {
            if (!emojiPicker.contains(e.target) && !emojiToggleBtn.contains(e.target)) {
                emojiPicker.classList.add('hidden');
            }
        });

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function renderAllMessages(messages) {
            const currentHash = JSON.stringify(messages);
            if (currentHash === lastRenderHash) return;
            lastRenderHash = currentHash;

            let html = '';
            messages.forEach(msg => {
                if (msg.pertanyaan_konsultasi) {
                    html += `
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                                <i class="fa-solid fa-user text-gray-600 text-lg"></i>
                            </div>
                            <div class="bg-gray-100 text-gray-900 border border-gray-200 p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-sm break-words">
                                ${escapeHtml(msg.pertanyaan_konsultasi)}
                            </div>
                        </div>
                    `;
                }
                if (msg.jawaban_konsultasi) {
                    html += `
                        <div class="flex items-start justify-end gap-3">
                            <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md break-words">
                                ${escapeHtml(msg.jawaban_konsultasi)}
                            </div>
                            <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center shrink-0 mt-1 shadow-md">
                                <i class="fa-solid fa-seedling text-emerald-700 text-lg"></i>
                            </div>
                        </div>
                    `;
                }
            });

            if (html !== '') {
                chatContainer.innerHTML = html;
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const messageText = replyInput.value.trim();
            if (!messageText) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            emojiPicker.classList.add('hidden');

            fetch(`/admin/konsultasi/${userId}/reply`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ message: messageText })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    replyInput.value = '';
                    fetchLatestMessages();
                } else {
                    alert('Gagal mengirim balasan.');
                }
            })
            .catch(err => console.error('Error:', err));
        });

        function fetchLatestMessages() {
            fetch(`/admin/konsultasi/${userId}/messages`, {
                headers: { "Accept": "application/json" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.messages) {
                    renderAllMessages(data.messages);
                }
            })
            .catch(err => console.error('Polling error:', err));
        }

        setInterval(fetchLatestMessages, 3000);
    });
    </script>

</body>
</html>