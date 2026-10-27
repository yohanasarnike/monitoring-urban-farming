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
<body class="bg-white w-screen h-screen m-0 p-0 overflow-hidden flex flex-col justify-between p-6 md:p-10 text-gray-800">

    <!-- Header Chat Atas -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <div class="flex items-center gap-4">
            <a href="/konsultasi" class="text-emerald-800 hover:text-emerald-950 transition">
                <i class="fa-solid fa-chevron-left text-2xl"></i>
            </a>
            <div class="w-12 h-12 rounded-full overflow-hidden bg-emerald-100 flex items-center justify-center shadow-sm border border-emerald-200">
                <img src="https://cdn-icons-png.flaticon.com/512/892/892926.png" alt="Logo" class="w-8 h-8 object-contain">
            </div>
            <div>
                <h2 class="font-bold text-lg md:text-2xl text-emerald-900 leading-tight">Konsultasi Urban Farming</h2>
                <p class="text-xs md:text-sm text-emerald-600 font-medium">Terhubung dengan Pakar Pertanian</p>
            </div>
        </div>
    </div>

    <!-- Area Chat Container -->
    <div id="chatContainer" class="flex-1 overflow-y-auto space-y-6 my-6 pr-4">
        
        <!-- Pesan Sambutan Pakar Default -->
        <div class="flex items-start gap-3">
            <img src="https://i.pravatar.cc/100?img=12" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md" alt="Pakar">
            <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md">
                Selamat datang di Konsultasi Urban Farming! Silahkan beri tahu kendala tanaman Anda, Pakar kami akan segera membalas dalam beberapa menit. Mohon ditunggu yaaa...
            </div>
        </div>

        <!-- Render Pesan Lama dari Database -->
        @if(isset($messages))
            @foreach($messages as$msg)
                @if(!empty($msg->pertanyaan_konsultasi))
                    <div class="flex items-start justify-end gap-3">
                        <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md">
                            {{ $msg->pertanyaan_konsultasi }}
                        </div>
                        <img src="https://i.pravatar.cc/100?img=3" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md" alt="User">
                    </div>
                @endif

                @if(!empty($msg->jawaban_konsultasi))
                    <div class="flex items-start gap-3">
                        <img src="https://i.pravatar.cc/100?img=12" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md" alt="Pakar">
                        <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tl-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md">
                            {{ $msg->jawaban_konsultasi }}
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

    </div>

    <!-- Form Input Chat Bar -->
    <form id="chatForm" action="javascript:void(0);" class="flex items-center gap-4 pt-4 border-t border-gray-100">
        <button type="button" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition shrink-0">
            <i class="fa-regular fa-face-smile"></i>
        </button>

        <div class="flex-1 bg-emerald-50/60 backdrop-blur-md border border-emerald-200/80 rounded-full flex items-center px-6 py-4 shadow-sm hover:shadow-md transition-all">
            <input type="text" id="messageInput" name="message" placeholder="Tulis kendala tanamanmu di sini..." class="w-full text-sm md:text-base text-gray-800 bg-transparent focus:outline-none placeholder:text-gray-400 font-medium" autocomplete="off" required>
        </div>

        <button type="submit" id="sendBtn" class="text-emerald-800 hover:text-emerald-950 text-3xl px-2 transition cursor-pointer shrink-0">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const chatContainer = document.getElementById('chatContainer');

        chatContainer.scrollTop = chatContainer.scrollHeight;

        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const messageText = messageInput.value.trim();
                if (!messageText) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch("{{ route('konsultasi.send') }}", {
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
                        const userBubble = `
                            <div class="flex items-start justify-end gap-3">
                                <div class="bg-[#045929] text-white p-4 md:p-5 rounded-3xl rounded-tr-none text-sm md:text-base leading-relaxed max-w-[85%] md:max-w-[60%] shadow-md">
                                    ${data.data.message}
                                </div>
                                <img src="https://i.pravatar.cc/100?img=3" class="w-10 h-10 rounded-full object-cover shrink-0 mt-1 shadow-md" alt="User">
                            </div>
                        `;
                        chatContainer.insertAdjacentHTML('beforeend', userBubble);
                        messageInput.value = '';
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    } else {
                        console.error('Gagal simpan:', data.message);
                        alert('Gagal menyimpan pesan: ' + data.message);
                    }
                })
                .catch(error => console.error('Error AJAX:', error));
            });
        }
    });
    </script>

</body>
</html>