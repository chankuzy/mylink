document.addEventListener('DOMContentLoaded', () => {
    generateChatList();
    initializeChat();
    initializeMessageInput();
    initializeTypingIndicator();
    initializeImageUpload();
});

function generateChatList() {
    const chatsList = document.getElementById('chatsList');
    const chats = [
        { name: 'Sarah Parker', message: "That's amazing! Can't wait to see...", time: '2m', online: true },
        { name: 'Alex Thompson', message: 'Did you check the new design?', time: '15m', online: true },
        { name: 'Creative Team', message: 'Meeting at 3 PM', time: '1h', group: true },
        { name: 'David Wilson', message: 'Thanks for the feedback!', time: '2h', online: false },
    ];

    chats.forEach((chat, index) => {
        if (index === 0) return; // Skip first chat as it's already in HTML
        const div = document.createElement('div');
        div.className = 'p-4 hover:bg-[#1c1f3a] cursor-pointer transition-all';
        div.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5">
                        <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                            <img src="${index % 2 === 0 ? 'akaza1.jpeg' : 'akaza2.jpeg'}" 
                                 alt="${chat.name}" 
                                 class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>
                    ${chat.online ? `
                        <div class="w-3 h-3 bg-green-500 rounded-full absolute bottom-0 right-0 border-2 border-[#161830]"></div>
                    ` : ''}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h3 class="font-medium">${chat.name}</h3>
                        <span class="text-xs text-gray-400">${chat.time}</span>
                    </div>
                    <p class="text-sm text-gray-400 truncate">${chat.message}</p>
                </div>
            </div>
        `;
        chatsList.appendChild(div);
    });
}

function initializeChat() {
    const messagesArea = document.getElementById('messagesArea');
    const messages = [
        { sent: false, text: 'Hey! How are you?', time: '10:30 AM' },
        { sent: true, text: `I'm doing great! Just finished the new design`, time: '10:31 AM' },
        { sent: false, text: `That's amazing! Can't wait to see it 😊`, time: `10:31 AM` },
        { sent: true, text: `Here's a preview:`, time: '10:32 AM', image: `akaza1.jpeg` },
        { sent: false, text: 'Wow! This looks incredible!', time: '10:33 AM' },
    ];

    messages.forEach(msg => {
        const div = document.createElement('div');
        div.className = `flex ${msg.sent ? 'justify-end' : 'justify-start'}`;
        div.innerHTML = `
            <div class="max-w-[70%] ${msg.sent ? 'bg-gradient-to-r from-purple-500 to-blue-500' : 'bg-[#1c1f3a]'} 
                        rounded-2xl p-3 ${msg.sent ? 'rounded-tr-none' : 'rounded-tl-none'}">
                ${msg.image ? `
                    <img src="${msg.image}" alt="Shared image" class="w-full rounded-lg mb-2">
                ` : ''}
                <p>${msg.text}</p>
                <span class="text-xs text-gray-300 mt-1 block">${msg.time}</span>
            </div>
        `;
        messagesArea.appendChild(div);
    });

    messagesArea.scrollTop = messagesArea.scrollHeight;
}

function initializeMessageInput() {
    const input = document.querySelector('input[placeholder="Type a message..."]');
    const sendButton = document.querySelector('.ri-send-plane-fill').parentElement;

    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && input.value.trim()) {
            sendMessage(input.value);
            input.value = '';
        }
    });

    sendButton.addEventListener('click', () => {
        if (input.value.trim()) {
            sendMessage(input.value);
            input.value = '';
        }
    });
}

function sendMessage(text) {
    const messagesArea = document.getElementById('messagesArea');
    const div = document.createElement('div');
    div.className = 'flex justify-end';
    div.innerHTML = `
        <div class="max-w-[70%] bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl rounded-tr-none p-3">
            <p>${text}</p>
            <span class="text-xs text-gray-300 mt-1 block">${new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })}</span>
        </div>
    `;
    messagesArea.appendChild(div);
    messagesArea.scrollTop = messagesArea.scrollHeight;
    
    // Simulate reply after 2 seconds
    showTypingIndicator();
    setTimeout(() => {
        hideTypingIndicator();
        simulateReply();
    }, 2000);
}

function showTypingIndicator() {
    const div = document.createElement('div');
    div.className = 'flex justify-start typing-indicator';
    div.innerHTML = `
        <div class="max-w-[70%] bg-[#1c1f3a] rounded-2xl rounded-tl-none p-3">
            <div class="flex gap-2">
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
            </div>
        </div>
    `;
    messagesArea.appendChild(div);
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

function hideTypingIndicator() {
    const indicator = document.querySelector('.typing-indicator');
    if (indicator) indicator.remove();
}

function simulateReply() {
    const replies = [
        "That's interesting!",
        'Tell me more about it!',
        'Sounds great!',
        'I see what you mean',
        'Thanks for sharing!'
    ];
    const randomReply = replies[Math.floor(Math.random() * replies.length)];
    const div = document.createElement('div');
    div.className = 'flex justify-start';
    div.innerHTML = `
        <div class="max-w-[70%] bg-[#1c1f3a] rounded-2xl rounded-tl-none p-3">
            <p>${randomReply}</p>
            <span class="text-xs text-gray-300 mt-1 block">${new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })}</span>
        </div>
    `;
    messagesArea.appendChild(div);
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

function initializeImageUpload() {
    const imageButton = document.querySelector('.ri-image-line').parentElement;
    imageButton.addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    sendImageMessage(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        };
        input.click();
    });
}

function sendImageMessage(imageData) {
    const div = document.createElement('div');
    div.className = 'flex justify-end';
    div.innerHTML = `
        <div class="max-w-[70%] bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl rounded-tr-none p-3">
            <img src="${imageData}" alt="Shared image" class="w-full rounded-lg mb-2">
            <span class="text-xs text-gray-300 mt-1 block">${new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })}</span>
        </div>
    `;
    messagesArea.appendChild(div);
    messagesArea.scrollTop = messagesArea.scrollHeight;
}