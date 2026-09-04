<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/gitania.css') }}">
    <style>
        :root {
            --purple-deep: #4a2e7a;
            --lilac-soft: #e2dcf5;
            --lilac-light: #faf8ff;
            --white: #ffffff;
            --text-dark: #2d2638;
            --accent-pink: #b93863;
            --border-soft: #fbcfe8;
        }
    </style>
</head>
<body class="font-sans antialiased" style="background: var(--bg-gray, #f8f9fa); margin: 0; color: var(--text-dark);">

    <div class="min-h-screen bg-gray-100" style="background: #faf8ff;">
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Tombol Chatbot Global (Z-Index Tertinggi) -->
    <button id="chatTrigger" style="position: fixed; bottom: 20px; right: 20px; padding: 12px 24px; background: #e11d48; color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.4); z-index: 2147483647; pointer-events: auto;">
        💬 Talk to Us!
    </button>

    <!-- Modal AI Chat -->
    <div id="chatModal" style="display: none; position: fixed; bottom: 80px; right: 20px; width: 350px; height: 500px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); overflow: hidden; flex-direction: column; z-index: 2147483647;">
        <div style="background: #e11d48; color: white; padding: 15px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
            <span>Gitania AI Assistant</span>
            <button id="chatCloseBtn" style="background: none; border: none; color: white; cursor: pointer; font-size: 16px;">✕</button>
        </div>
        <div id="chatBox" style="flex: 1; padding: 15px; overflow-y: auto; background: #f9fafb; display: flex; flex-direction: column; gap: 10px;">
            <div style="align-self: flex-start; background: #e5e7eb; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #374151;">
                Halo! Ada yang bisa dibantu seputar produk Gitania Skincare? 😊
            </div>
        </div>
        <div style="padding: 10px; border-top: 1px solid #eee; display: flex; background: white;">
            <input type="text" id="chatInput" placeholder="Tanya sesuatu..." style="flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; font-size: 13px;">
            <button id="chatSendBtn" style="margin-left: 5px; padding: 8px 15px; background: #e11d48; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Kirim</button>
        </div>
    </div>

    <!-- Script Global Chatbot -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatTrigger = document.getElementById('chatTrigger');
            const chatModal = document.getElementById('chatModal');
            const chatCloseBtn = document.getElementById('chatCloseBtn');
            const chatSendBtn = document.getElementById('chatSendBtn');
            const chatInput = document.getElementById('chatInput');
            const chatBox = document.getElementById('chatBox');

            function toggleChatModal() {
                if (chatModal.style.display === 'none' || chatModal.style.display === '') {
                    chatModal.style.display = 'flex';
                } else {
                    chatModal.style.display = 'none';
                }
            }

            if (chatTrigger) {
                chatTrigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleChatModal();
                });
            }

            if (chatCloseBtn) {
                chatCloseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    chatModal.style.display = 'none';
                });
            }

            if (chatSendBtn) {
                chatSendBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sendUserMessage();
                });
            }

            if (chatInput) {
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        sendUserMessage();
                    }
                });
            }

            function sendUserMessage() {
                let msg = chatInput.value.trim();
                if (!msg) return;

                chatBox.innerHTML += '<div style="align-self: flex-end; background: #fee2e2; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #991b1b; max-width: 80%;">' + msg + '</div>';
                chatInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight;

                let loadingId = 'loading-' + Date.now();
                chatBox.innerHTML += '<div id="' + loadingId + '" style="align-self: flex-start; background: #e5e7eb; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #6b7280;">Sedang mengetik...</div>';
                chatBox.scrollTop = chatBox.scrollHeight;

                fetch("/ai-chat", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: msg })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    let loadingElement = document.getElementById(loadingId);
                    if (loadingElement) loadingElement.remove();

                    if (data.success) {
                        chatBox.innerHTML += '<div style="align-self: flex-start; background: #e5e7eb; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #374151; max-width: 80%;">' + data.reply + '</div>';
                    } else {
                        chatBox.innerHTML += '<div style="align-self: flex-start; background: #fee2e2; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #b91c1c;">' + data.reply + '</div>';
                    }
                    chatBox.scrollTop = chatBox.scrollHeight;
                })
                .catch(function(err) {
                    let loadingElement = document.getElementById(loadingId);
                    if (loadingElement) loadingElement.remove();
                    chatBox.innerHTML += '<div style="align-self: flex-start; background: #fee2e2; padding: 8px 12px; border-radius: 10px; font-size: 13px; color: #b91c1c;">Terjadi kesalahan koneksi ke server.</div>';
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
            }
        });
    </script>
</body>
</html>
