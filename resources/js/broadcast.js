window.listenBroadcast = async function (userId) {
    const { default: Echo } = await import('laravel-echo');
    const { default: Pusher } = await import('pusher-js');

    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
        wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
        wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    window.Echo.private(`notifications.${userId}`).listen(".notification", e => {
        console.log('here');
    });

    window.Echo.private(`messages.${userId}`).listen(".new-message", messagesChannelEvent);
}

window.messagesChannelEvent = function (e) {
    let unreadSignal = document.getElementById('messages-signal');
    if (unreadSignal.innerText != '9+') {
        if (unreadSignal.innerText == 9) unreadSignal.innerText = '9+';
        else unreadSignal.innerText++;
    }
    unreadSignal.classList.remove('hidden');

    let date = new Date(Date.parse(e.created_at.replace(/ /g, "T")));
    if (date == 'Invalid Date') date = new Date(+e.created_at);

    date = date.toLocaleDateString(window.locale, {
        month: "short",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    });

    // CHAT
    let chat = document.getElementById('chat-' + e.chat_id);
    if (chat) {
        chat.getElementsByClassName('message')[0].innerText = e.message ? e.message : 'Files';
        chat.getElementsByClassName('date-transform')[0].innerText = date;

        if (!chat.classList.contains('border-indigo-500')) {
            chat.classList.add('bg-slate-50', 'dark:bg-slate-800');
            document.getElementById('chat-signal-' + e.chat_id).classList.remove('hidden');
        }
    } else document.getElementById('chat-list').insertAdjacentHTML('afterbegin', `
        <a href="/chat/${e.chat_id}" id="chat-${e.chat_id}"
            class="rounded-lg hover:bg-slate-100 dark:hover:bg-slate-950 block p-2 xs:p-3 bg-slate-50 dark:bg-slate-800">
            <li>
                <div id="chat-signal-${e.chat_id}"
                    class="absolute block w-2 h-2 xs:w-3 xs:h-3 bg-red-500 border xs:border-2 border-white dark:border-slate-950 rounded-full top-0.5 end-0.5 xs:top-1 xs:end-1">
                </div>

                <div class="flex">
                    <p class="w-full text-xs font-semibold text-slate-950 dark:text-slate-100">${e.from}</p>

                    <div class="min-w-fit text-right ml-2">
                        <p class="text-xxs text-slate-950 dark:text-slate-100">${e.from_status}</p>
                        <p class="date-transform mt-0.5 xs:mt-1 text-xxs text-slate-600">${date}</p>
                    </div>
                </div>

                <p class="mt-1 xs:mt-2 truncate text-xs leading-5 text-slate-600 message">${e.message ? e.message : 'Files'}</p>
            </li>
        </a>
    `);

    // MESSAGE lIST
    let messagesList = document.getElementById('chat-messages');
    if (messagesList && messagesList.getAttribute('data-chat_id') == e.chat_id) {
        let messageElement = ``;

        if (e.message) messageElement = messageElement + `<div class="flex justify-start">
        <div
            class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-b-xl mr-6 rounded-tr-xl">
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                <span class="text-xs text-slate-600">${date}</span>
            </div>

            <p class="text-sm text-slate-950 dark:text-slate-50 whitespace-pre-line">${e.message}</p>
            </div>
        </div>`;

        if (e.images.length) {
            messageElement = messageElement + `<div class="flex justify-start">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-b-xl mr-6 rounded-tr-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs text-slate-600">${date}</span>
                </div>
                <div class="grid gap-2 ${e.images.length > 1 ? e.images.length > 4 ? 'grid-cols-3' : 'grid-cols-2' : 'grid-cols-1'}">`;

            for (let image of e.images) {
                messageElement = messageElement + `<img src="/storage/${image}" class="rounded-lg" />`;
            }

            messageElement = messageElement + `</div></div></div>`;
        }

        if (e.files.length) {
            messageElement = messageElement + `<div class="flex justify-start">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-b-xl mr-6 rounded-tr-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs text-slate-600">${date}</span>
                </div>
                <div class="space-y-2">`;

            for (let file of e.files) {
                messageElement = messageElement + `<div class="bg-slate-100 dark:bg-slate-800 p-3 rounded-lg">
                    <div class="flex items-center">
                        <div class="rounded-md overflow-hidden min-w-14 w-14 h-14 mr-4 bg-white dark:bg-slate-950 flex items-center justify-center">
                            <svg class="w-7 h-7 text-slate-600 aria-hidden="true" fill="none" viewBox="0 0 16 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 17V2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M5 15V1m8 18v-4">
                                </path>
                            </svg>
                        </div>

                        <div>
                            <div class="text-slate-950 dark:text-slate-100 font-semibold mb-1">${file.name}</div>

                            <div class="flex">
                                <a class="hover:underline text-slate-600" download href="/storage/${file.path}">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            messageElement = messageElement + `</div></div></div>`;
        }

        messagesList.insertAdjacentHTML('beforeend', messageElement);

        messagesList.scrollTo(0, messagesList.scrollHeight);
    }
}