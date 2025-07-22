class ChatWidget {
    constructor() {
        this.isOpen = false;
        this.apiEndpoint = '/api/chat';
        this.init();
    }

    init() {
        this.bindEvents();
        this.autoResize();
    }

    bindEvents() {
        const chatButton = document.getElementById('chatButton');
        const closeChat = document.getElementById('closeChat');
        const sendButton = document.getElementById('sendButton');
        const messageInput = document.getElementById('messageInput');
        const quickReplies = document.getElementById('quickReplies');

        chatButton.addEventListener('click', () => this.toggleChat());
        closeChat.addEventListener('click', () => this.closeChat());
        sendButton.addEventListener('click', () => this.sendMessage());

        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        messageInput.addEventListener('input', () => this.autoResize());

        quickReplies.addEventListener('click', (e) => {
            if (e.target.classList.contains('quick-reply-btn') || e.target.closest('.quick-reply-btn')) {
                const button = e.target.closest('.quick-reply-btn');
                const message = button.getAttribute('data-message');
                this.sendQuickReply(message);
            }
        });
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        const container = document.getElementById('chatContainer');
        const button = document.getElementById('chatButton');
        const icon = document.getElementById('chatIcon');

        container.classList.add('show');
        button.classList.add('active');
        icon.textContent = '×';
        this.isOpen = true;
        this.hideNotification();

        setTimeout(() => {
            document.getElementById('messageInput').focus();
        }, 300);
    }

    closeChat() {
        const container = document.getElementById('chatContainer');
        const button = document.getElementById('chatButton');
        const icon = document.getElementById('chatIcon');

        container.classList.remove('show');
        button.classList.remove('active');
        icon.textContent = '💬';
        this.isOpen = false;
    }

    async sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();

        if (!message) return;

        this.addMessage(message, 'user');
        input.value = '';
        this.autoResize();

        this.hideQuickReplies();

        this.showTyping();

        try {
            const response = await this.sendToAPI(message);

            let responseMessage = response.message
            if (response.message.error) {
                responseMessage = "Chatbot is not available!";
            }

            this.hideTyping();

            this.addMessage(responseMessage, 'bot');

            this.showContextualQuickReplies(response);
        } catch (error) {
            this.hideTyping();
            this.addMessage('Sorry, something went wrong. Please try again.', 'bot');
            console.error('Chat API Error:', error);
        }
    }

    async sendToAPI(message) {
        const response = await fetch(this.apiEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({
                message: message
            })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return await response.json();
    }

    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;

        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const contentDiv = document.createElement('div');
        contentDiv.innerHTML = text; // biarkan browser render HTML-nya

        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        timeDiv.textContent = timeString;

        console.log('Bot message:', text);


        messageDiv.appendChild(contentDiv);
        messageDiv.appendChild(timeDiv);


        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    showTyping() {
        const indicator = document.getElementById('typingIndicator');
        indicator.style.display = 'flex';

        const messagesContainer = document.getElementById('chatMessages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTyping() {
        const indicator = document.getElementById('typingIndicator');
        indicator.style.display = 'none';
    }

    showNotification() {
        const badge = document.getElementById('notificationBadge');
        badge.style.display = 'flex';
    }

    hideNotification() {
        const badge = document.getElementById('notificationBadge');
        badge.style.display = 'none';
    }

    autoResize() {
        const textarea = document.getElementById('messageInput');
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 80) + 'px';
    }

    getSessionId() {
        let sessionId = localStorage.getItem('chat_session_id');
        if (!sessionId) {
            sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('chat_session_id', sessionId);
        }
        return sessionId;
    }

    sendQuickReply(message) {
        // Add user message to chat
        this.addMessage(message, 'user');

        // Hide quick replies
        this.hideQuickReplies();

        // Show typing indicator
        this.showTyping();

        // Send to API
        this.sendToAPI(message).then(response => {
            this.hideTyping();
            this.addMessage(response.message, 'bot');
            this.showContextualQuickReplies(response);
        }).catch(error => {
            this.hideTyping();
            this.addMessage('Sorry, something went wrong. Please try again.', 'bot');
            console.error('Chat API Error:', error);
        });
    }

    hideQuickReplies() {
        const quickReplies = document.getElementById('quickReplies');
        quickReplies.style.display = 'none';
    }

    showQuickReplies() {
        const quickReplies = document.getElementById('quickReplies');
        quickReplies.style.display = 'flex';
    }

    showContextualQuickReplies(response) {
        const quickReplies = document.getElementById('quickReplies');

        // Clear existing quick replies
        quickReplies.innerHTML = '';

        // Add contextual quick replies based on bot response
        let contextualReplies = [];

        const responseText = response.message.toLowerCase();

        contextualReplies = [
            // { text: "Saya tertarik", icon: "😍" },
            // { text: "Info lebih detail", icon: "📋" },
            // { text: "Terima kasih", icon: "🙏" }
        ];

        // Add quick reply buttons
        contextualReplies.forEach(reply => {
            const button = document.createElement('button');
            button.className = 'quick-reply-btn';
            button.setAttribute('data-message', reply.text);
            button.innerHTML = `<span class="icon">${reply.icon}</span>${reply.text}`;
            quickReplies.appendChild(button);
        });

        // Show quick replies
        this.showQuickReplies();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ChatWidget();
});
