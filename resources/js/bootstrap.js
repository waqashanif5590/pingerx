import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// console.log('🔧 Initializing Echo with key:', import.meta.env.VITE_PUSHER_APP_KEY);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});

// Connection debugging
const connection = window.Echo.connector.pusher.connection;

// connection.bind('connected', () => {
//     console.log('✅ Pusher Connected! Socket ID:', window.Echo.socketId());
// });

// connection.bind('connecting', () => {
//     console.log('🔄 Connecting to Pusher...');
// });

// connection.bind('error', (err) => {
//     console.error('❌ Pusher Error:', err);
//     console.error('Key being used:', import.meta.env.VITE_PUSHER_APP_KEY);
// });

// connection.bind('disconnected', () => {
//     console.warn('⚠️ Pusher Disconnected');
// });

// Notification listener
document.addEventListener('DOMContentLoaded', () => {
    if (window.userId) {
        // console.log('👤 Subscribing to private channel: users.' + window.userId);

        window.Echo.private(`users.${window.userId}`)
            .notification((notification) => {
                // console.log('📬 New notification:', notification);

                if (notification.type !== 'message.sent' || !notification.message) {
                    return;
                }

                Livewire.dispatch('messageReceived', {
                    conversationId: notification.conversation_id,
                    message: notification.message
                });
            });
    } else {
        console.warn('⚠️ window.userId is not set!');
    }
});
