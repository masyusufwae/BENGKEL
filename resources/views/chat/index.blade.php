<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pusat Pesan & Chat - Bengkel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f1f5f9; }
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
        .msg-me { background: #3b82f6; color: white; margin-left: auto; border-bottom-right-radius: 0 !important; }
        .msg-other { background: #fff; color: #1e293b; border border-gray-200; margin-right: auto; border-bottom-left-radius: 0 !important; }
    </style>
</head>
<body class="h-screen overflow-hidden flex flex-col font-sans">
    
    <!-- Navbar -->
    <nav class="bg-slate-900 shadow-lg px-6 py-4 flex justify-between items-center text-white shrink-0">
        <div class="flex items-center space-x-4">
            <!-- Go back to role specific dashboard -->
            <a href="@if(auth()->user()->role == 'pelanggan') {{ route('dashboard') }} @elseif(auth()->user()->role == 'mekanik') {{ route('mekanik.work-order.index') }} @else {{ route('admin.dashboard') }} @endif" class="text-slate-400 hover:text-white transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-xl font-bold flex items-center tracking-wide">
                <i class="fas fa-comments text-blue-500 mr-2"></i> BENGKEL<span class="font-light text-cyan-400">CHAT</span>
            </h1>
        </div>
        <div class="text-sm font-semibold text-slate-300">
            <span class="bg-blue-600/30 text-blue-400 px-2 py-1 rounded border border-blue-500/30 uppercase text-xs mr-2">{{ auth()->user()->role }}</span>
            {{ auth()->user()->name }}
        </div>
    </nav>

    <!-- Main App -->
    <div class="flex-1 flex overflow-hidden w-full max-w-[1400px] mx-auto bg-white shadow-xl border-l border-r border-slate-200">
        
        <!-- Sidebar Contacts -->
        <div class="w-1/3 md:w-1/4 border-r border-gray-200 bg-slate-50 flex flex-col">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="font-bold text-slate-800 text-sm uppercase tracking-wider"><i class="fas fa-users mr-2 text-slate-400"></i> Kontak Tersedia</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-gray-100" id="contact-list">
                    @foreach($contacts as $contact)
                    <li class="contact-item p-4 hover:bg-blue-50 cursor-pointer transition-colors" data-id="{{ $contact->id }}" data-name="{{ $contact->name }}" data-role="{{ $contact->role }}" onclick="selectContact({{ $contact->id }}, '{{ $contact->name }}', '{{ $contact->role }}')">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3 w-full">
                                <div class="relative w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center border border-slate-300 text-slate-500 font-bold text-lg shrink-0">
                                    {{ substr($contact->name, 0, 1) }}
                                </div>
                                <div class="w-full overflow-hidden">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-slate-800 text-sm contact-name truncate">{{ $contact->name }}</h3>
                                        <span class="text-[10px] text-slate-400 contact-time whitespace-nowrap ml-2">{{ $contact->last_message_time }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="text-xs text-slate-500 truncate mr-2 contact-preview">{{ \Illuminate\Support\Str::limit($contact->last_message, 30) }}</p>
                                        @if($contact->unread_count > 0)
                                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full unread-badge">{{ $contact->unread_count }}</span>
                                        @else
                                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full unread-badge hidden"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-slate-100/50 relative">
            <!-- Blank State -->
            <div id="blank-state" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-50 z-10 text-center">
                <i class="fas fa-comment-dots text-6xl text-slate-300 mb-4"></i>
                <h3 class="text-xl font-bold text-slate-600">Pilih Kontak</h3>
                <p class="text-slate-400 text-sm mt-2 max-w-sm">Pilih nama kontak dari disebelah kiri untuk memulai atau membaca percakapan (Realtime).</p>
            </div>

            <!-- Chat Header -->
            <div id="chat-header" class="border-b border-gray-200 bg-white px-6 py-4 flex items-center shadow-sm opacity-0 pointer-events-none transition-opacity hidden">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center border border-indigo-200 text-indigo-700 font-bold text-lg mr-4" id="chat-avatar">
                   ?
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 text-base" id="chat-title">Nama Target</h2>
                    <span class="text-green-500 text-xs font-semibold flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>Online</span>
                </div>
            </div>

            <!-- Chat Body -->
            <div id="chat-body" class="flex-1 overflow-y-auto chat-scroll p-6 space-y-4 opacity-0 transition-opacity hidden">
                 <!-- Injected Messages -->
            </div>

            <!-- Chat Input -->
            <div id="chat-input-area" class="bg-white border-t border-gray-200 px-4 py-4 flex items-end space-x-3 opacity-0 pointer-events-none transition-opacity hidden">
                <input type="hidden" id="current_receiver_id">
                <textarea id="message_input" class="w-full border border-gray-300 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white resize-none" rows="2" placeholder="Ketik pesan Anda disini..."></textarea>
                <button onclick="sendMessage()" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-3 shadow transition-colors flex items-center justify-center">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentContactId = null;
        let myId = {{ auth()->id() }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        let pollingInterval = null;

        function selectContact(id, name, role) {
            currentContactId = id;
            document.getElementById('current_receiver_id').value = id;
            document.getElementById('chat-title').innerText = name;
            document.getElementById('chat-avatar').innerText = name.substring(0, 1);
            
            // Clean up UI states
            document.getElementById('blank-state').classList.add('hidden');
            
            const header = document.getElementById('chat-header');
            const body = document.getElementById('chat-body');
            const input = document.getElementById('chat-input-area');
            
            header.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            body.classList.remove('hidden', 'opacity-0');
            input.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            
            // Remove active highlight from all items
            document.querySelectorAll('.contact-item').forEach(el => {
                el.classList.remove('bg-blue-100', 'border-l-4', 'border-blue-500');
            });
            // Add active highlight on clicked
            document.querySelector(`.contact-item[data-id="${id}"]`).classList.add('bg-blue-100', 'border-l-4', 'border-blue-500');
            
            // Immediately Fetch
            fetchMessages();
            
            // Stop old polling
            if(pollingInterval) clearInterval(pollingInterval);
            // Start AJAX Polling Realtime Effect (Every 3 seconds)
            pollingInterval = setInterval(() => {
                fetchMessages();
                fetchContacts();
            }, 3000);
        }

        function fetchContacts() {
            fetch(`/chat/contacts/summary`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(c => {
                        let el = document.querySelector(`.contact-item[data-id="${c.id}"]`);
                        if (el) {
                            let preview = el.querySelector('.contact-preview');
                            let time = el.querySelector('.contact-time');
                            let badge = el.querySelector('.unread-badge');

                            if (preview) preview.innerText = c.last_message;
                            if (time) time.innerText = c.last_message_time;

                            if (c.unread_count > 0 && currentContactId != c.id) {
                                badge.innerText = c.unread_count;
                                badge.classList.remove('hidden');
                                el.classList.add('bg-blue-50/50');
                            } else {
                                badge.classList.add('hidden');
                                el.classList.remove('bg-blue-50/50');
                            }
                        }
                    });
                });
        }

        function fetchMessages() {
            if(!currentContactId) return;

            fetch(`/chat/messages/${currentContactId}`)
                .then(res => res.json())
                .then(data => {
                    const chatBody = document.getElementById('chat-body');
                    
                    // Simple logic to detect if we need scrolling
                    let isScrolledToBottom = chatBody.scrollHeight - chatBody.clientHeight <= chatBody.scrollTop + 50;
                    
                    chatBody.innerHTML = '';
                    if(data.length === 0) {
                        chatBody.innerHTML = `<div class="text-center text-slate-400 text-xs my-10">Mulai percakapan dengan mengirimkan pesan.</div>`;
                    }
                    
                    data.forEach(msg => {
                        let isMe = msg.sender_id === myId;
                        let wrapperClass = isMe ? 'flex justify-end' : 'flex justify-start';
                        let bubbleClass = isMe ? 'msg-me' : 'msg-other';
                        let time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        
                        // Check ticks 
                        let ticks = isMe ? (msg.is_read ? '<i class="fas fa-check-double text-blue-200"></i>' : '<i class="fas fa-check text-blue-200"></i>') : '';

                        let html = `
                        <div class="${wrapperClass} w-full">
                            <div class="max-w-[70%] rounded-2xl px-4 py-3 text-sm shadow-sm ${bubbleClass}">
                                <p class="mb-1 leading-relaxed">${msg.message}</p>
                                <div class="text-[10px] text-right mt-1 opacity-70 border-t border-white/10 pt-1 flex justify-end items-center gap-1">
                                    <span>${time}</span>
                                    <span>${ticks}</span>
                                </div>
                            </div>
                        </div>`;
                        chatBody.insertAdjacentHTML('beforeend', html);
                    });
                    
                    // Scroll to bottom
                    if (isScrolledToBottom) {
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }
                });
        }

        function sendMessage() {
            let input = document.getElementById('message_input');
            let msg = input.value.trim();
            if(!msg || !currentContactId) return;

            let submitBtn = event.currentTarget;
            submitBtn.disabled = true;

            fetch(`/chat/send`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    receiver_id: currentContactId,
                    message: msg
                })
            })
            .then(res => res.json())
            .then(data => {
                input.value = '';
                submitBtn.disabled = false;
                fetchMessages(); // refresh map
                fetchContacts(); // refresh preview
                setTimeout(() => {
                    let chatBody = document.getElementById('chat-body');
                    chatBody.scrollTop = chatBody.scrollHeight;
                }, 100);
            })
            .catch(err => {
                alert('Gagal mengirim pesan');
                submitBtn.disabled = false;
            });
        }
        
        // Enter to send
        document.getElementById('message_input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

    </script>
</body>
</html>