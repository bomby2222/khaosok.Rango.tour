@extends('layouts.admin')

@section('title', 'LIVE CHAT TERMINAL // RANGO ADMIN')
@section('header', 'LIVE CHAT COMMAND TERMINAL')

@section('content')
<div class="glass-panel rounded-[2.5rem] border border-emerald-500/20 shadow-2xl overflow-hidden h-[780px] flex flex-col md:flex-row relative" x-data="adminChatConsole()">

    <!-- Left Column: Chat Inquiries List (4 Cols) -->
    <div class="w-full md:w-80 lg:w-96 border-r border-zinc-800 bg-[#08090b] flex flex-col shrink-0">
        <div class="p-4 sm:p-5 border-b border-zinc-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-white uppercase tracking-wider">Active Guest Chats</h3>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-[10px] font-mono-code text-emerald-400 font-bold">Auto-Sync 3s</span>
                </div>
            </div>

            <button @click="toggleSound()" 
                    :class="soundEnabled ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/40' : 'bg-zinc-900 text-zinc-500 border-zinc-800'"
                    class="px-2.5 py-1.5 rounded-xl border text-[10px] font-mono-code font-bold transition flex items-center gap-1">
                <span x-text="soundEnabled ? '🔔 Sound ON' : '🔕 Sound OFF'"></span>
            </button>
        </div>

        <!-- Chat List Items -->
        <div class="flex-grow overflow-y-auto divide-y divide-zinc-900">
            <template x-for="chat in chatsList" :key="chat.id">
                <div @click="selectChat(chat)" 
                     :class="activeChat && activeChat.id === chat.id ? 'bg-zinc-900/90 border-l-4 border-emerald-500' : 'hover:bg-zinc-900/40'" 
                     class="p-4 cursor-pointer transition flex items-start justify-between gap-3 relative group">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs font-mono-code shrink-0 relative">
                            💬
                            <template x-if="chat.unread_count > 0">
                                <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] flex items-center justify-center font-black animate-bounce" x-text="chat.unread_count"></span>
                            </template>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-white truncate" x-text="chat.guest_name"></h4>
                            <p class="text-[11px] text-zinc-400 line-clamp-1 mt-0.5" x-text="chat.last_message || 'Started chat'"></p>
                        </div>
                    </div>
                    <span class="text-[9px] font-mono-code text-zinc-500 shrink-0" x-text="chat.last_time || ''"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Right Column: Live Conversation Window (8 Cols) -->
    <div class="flex-grow flex flex-col justify-between bg-[#060708] relative">
        <!-- Selected Chat Header -->
        <div class="p-4 sm:p-5 border-b border-zinc-800 bg-black/60 flex items-center justify-between">
            <template x-if="activeChat">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-white" x-text="activeChat.guest_name"></h4>
                            <button type="button" @click="openRenameModal()" class="text-xs text-emerald-400 hover:underline font-mono-code">
                                [✏️ Rename]
                            </button>
                        </div>
                        <span class="text-[10px] font-mono-code text-zinc-400" x-text="'Session: ' + activeChat.session_id"></span>
                    </div>
                </div>
            </template>
            <template x-if="!activeChat">
                <span class="text-xs font-mono-code text-zinc-500">Please select a conversation from the left</span>
            </template>

            <template x-if="activeChat">
                <button type="button" 
                        @click="openConfirmDelete()" 
                        class="px-3 py-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 text-rose-400 hover:text-rose-300 border border-rose-900/60 text-xs font-mono-code transition duration-200 flex items-center gap-1.5 shadow-sm">
                    <span>🗑️</span> Delete Session
                </button>
            </template>
        </div>

        <!-- Messages Thread Stream -->
        <div id="adminMessagesThread" class="flex-grow p-4 sm:p-6 overflow-y-auto space-y-4">
            <template x-if="!activeChat">
                <div class="h-full flex flex-col items-center justify-center text-center text-zinc-500">
                    <span class="text-4xl block mb-2">💬</span>
                    <p class="text-xs font-mono-code">Select a traveler guest chat to start replying in real-time.</p>
                </div>
            </template>

            <template x-for="msg in currentMessages" :key="msg.id">
                <div :class="msg.sender === 'admin' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender === 'admin' ? 'bg-emerald-500 text-black font-semibold rounded-br-sm' : 'bg-zinc-900 text-zinc-200 rounded-tl-sm border border-zinc-800'"
                         class="p-3.5 sm:p-4 rounded-2xl max-w-[85%] sm:max-w-[75%] text-xs leading-relaxed shadow-md">
                        <p class="whitespace-pre-line" x-text="msg.message"></p>
                        <span :class="msg.sender === 'admin' ? 'text-black/60' : 'text-zinc-500'" class="text-[9px] font-mono-code block text-right mt-1" x-text="msg.time"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Quick Reply Snippets & Input Box -->
        <div class="p-4 border-t border-zinc-800 bg-[#090b0d] space-y-3" x-show="activeChat">
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-[11px] font-mono-code">
                <button @click="sendQuickReply('สวัสดีครับ! ยินดีต้อนรับสู่ Rango Tour ครับ ต้องการสอบถามข้อมูลด้านใดแจ้งได้เลยครับ')" class="px-3 py-1 rounded-lg bg-zinc-900 hover:bg-emerald-950 text-zinc-300 hover:text-emerald-300 border border-zinc-800 whitespace-nowrap transition">
                    👋 ทักทาย
                </button>
                <button @click="sendQuickReply('แพเขื่อนเชี่ยวหลานรวมอาหาร 3 มื้อ และเรือนำเที่ยวแล้วครับ')" class="px-3 py-1 rounded-lg bg-zinc-900 hover:bg-emerald-950 text-zinc-300 hover:text-emerald-300 border border-zinc-800 whitespace-nowrap transition">
                    🛶 สิ่งที่รวมในแพ็กเกจ
                </button>
                <button @click="sendQuickReply('มีรอบเดินทางว่างสำหรับวันที่ท่านสนใจครับ สะดวกจองกี่ท่านดีครับ')" class="px-3 py-1 rounded-lg bg-zinc-900 hover:bg-emerald-950 text-zinc-300 hover:text-emerald-300 border border-zinc-800 whitespace-nowrap transition">
                    🗓️ เช็คที่นั่งว่าง
                </button>
            </div>

            <form @submit.prevent="submitReply()" class="flex items-center gap-3">
                <input type="text" x-model="replyText" placeholder="Type your response to guest..." required
                       class="flex-grow bg-black text-white border border-zinc-700 rounded-xl px-4 py-3 text-xs font-mono-code focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-black font-black px-6 py-3 rounded-xl text-xs uppercase tracking-wider transition">
                    Send Reply
                </button>
            </form>
        </div>
    </div>


    <!-- =========================================================================
         ADMIN RENAME CHAT MODAL (หน้าต่างเปลี่ยนชื่อลูกค้า)
         ========================================================================= -->
    <div x-show="showRenameModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        <div @click.away="showRenameModal = false" class="glass-panel border border-emerald-500/30 rounded-3xl max-w-sm w-full p-6 text-center">
            <h3 class="text-base font-black text-white uppercase tracking-wider mb-2">Rename Chat / Add Notes</h3>
            <p class="text-xs text-zinc-400 mb-4">Set a custom name or booking note for this customer.</p>

            <form @submit.prevent="submitRename()" class="space-y-3">
                <input type="text" x-model="renameInput" required placeholder="เช่น คุณสมชาย (จองแพ 3 ท่าน)..." 
                       class="w-full bg-black text-white border border-zinc-700 rounded-xl p-3 text-xs font-mono-code focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="button" @click="showRenameModal = false" class="py-2.5 bg-zinc-900 text-zinc-400 rounded-xl text-xs font-bold">Cancel</button>
                    <button type="submit" class="py-2.5 bg-emerald-500 text-black font-black rounded-xl text-xs uppercase">Save Name</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        <div @click.away="showDeleteModal = false" class="glass-panel border border-rose-500/30 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl text-center">
            <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 mx-auto flex items-center justify-center text-2xl mb-4">⚠️</div>
            <h3 class="text-lg font-black text-white uppercase tracking-wider mb-2">Delete Conversation?</h3>
            <p class="text-xs text-zinc-300 leading-relaxed mb-4">Are you sure you want to delete this chat session?</p>
            <form :action="'/rango-admin/chats/' + (activeChat ? activeChat.id : '')" method="POST" id="deleteChatForm">
                @csrf
                @method('DELETE')
            </form>
            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" @click="showDeleteModal = false" class="py-3 rounded-xl bg-zinc-900 text-zinc-300 text-xs font-bold">Cancel</button>
                <button type="button" @click="document.getElementById('deleteChatForm').submit()" class="py-3 rounded-xl bg-rose-600 text-white font-black text-xs uppercase">Yes, Purge</button>
            </div>
        </div>
    </div>

</div>

<!-- Alpine Script -->
<script>
    function adminChatConsole() {
        return {
            chatsList: @json($chats),
            activeChat: null,
            currentMessages: [],
            replyText: '',
            renameInput: '',
            showDeleteModal: false,
            showRenameModal: false,
            soundEnabled: true,
            totalKnownMessages: 0,
            polling: null,

            init() {
                if (this.chatsList.length > 0) {
                    this.selectChat(this.chatsList[0]);
                }
                this.calculateTotalMessages();

                this.polling = setInterval(() => {
                    this.syncAllChatData();
                }, 3000);
            },

            toggleSound() {
                this.soundEnabled = !this.soundEnabled;
            },

            playNotificationSound() {
                if (!this.soundEnabled) return;
                try {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    if (!AudioContext) return;
                    const ctx = new AudioContext();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.3, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.35);
                } catch (e) {}
            },

            calculateTotalMessages() {
                let count = 0;
                this.chatsList.forEach(c => { count += c.messages_count || (c.messages ? c.messages.length : 0); });
                this.totalKnownMessages = count;
            },

            selectChat(chat) {
                this.activeChat = chat;
                this.refreshActiveConversation();
            },

            openRenameModal() {
                if (!this.activeChat) return;
                this.renameInput = this.activeChat.guest_name;
                this.showRenameModal = true;
            },

            submitRename() {
                if (!this.renameInput.trim() || !this.activeChat) return;
                const newName = this.renameInput.trim();

                fetch(`/rango-admin/chats/${this.activeChat.id}/rename`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ guest_name: newName })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.activeChat.guest_name = newName;
                        const item = this.chatsList.find(c => c.id === this.activeChat.id);
                        if (item) item.guest_name = newName;
                        this.showRenameModal = false;
                    }
                });
            },

            openConfirmDelete() {
                this.showDeleteModal = true;
            },

            syncAllChatData() {
                fetch('/rango-admin/chats', { headers: { 'Accept': 'application/json' } })
                    .then(res => res.json())
                    .then(data => {
                        if (data.chats) {
                            let newTotal = 0;
                            data.chats.forEach(c => { newTotal += c.messages_count; });

                            if (newTotal > this.totalKnownMessages) {
                                this.playNotificationSound();
                                this.totalKnownMessages = newTotal;
                            }

                            this.chatsList = data.chats;

                            if (this.activeChat) {
                                const updated = this.chatsList.find(c => c.id === this.activeChat.id);
                                if (updated) {
                                    this.activeChat.guest_name = updated.guest_name;
                                }
                            }
                        }
                    })
                    .catch(err => console.error(err));

                if (this.activeChat && !this.showDeleteModal && !this.showRenameModal) {
                    this.refreshActiveConversation();
                }
            },

            refreshActiveConversation() {
                if (!this.activeChat) return;
                fetch(`/rango-admin/chats/${this.activeChat.id}/conversation`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.messages && data.messages.length !== this.currentMessages.length) {
                            this.currentMessages = data.messages;
                            this.scrollToBottom();
                        }
                    });
            },

            submitReply() {
                if (!this.replyText.trim() || !this.activeChat) return;
                const text = this.replyText;
                this.replyText = '';

                fetch(`/rango-admin/chats/${this.activeChat.id}/reply`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.currentMessages.push(data.message);
                        this.totalKnownMessages++;
                        this.scrollToBottom();
                    }
                });
            },

            sendQuickReply(text) {
                this.replyText = text;
                this.submitReply();
            },

            scrollToBottom() {
                setTimeout(() => {
                    const thread = document.getElementById('adminMessagesThread');
                    if (thread) thread.scrollTop = thread.scrollHeight;
                }, 100);
            }
        }
    }
</script>
@endsection