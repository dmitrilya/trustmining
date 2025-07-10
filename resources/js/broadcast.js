window.listenBroadcast = function (userId) {
    userId = userId.getAttribute('content');

    Echo.private(`notifications.${userId}`).listen(".notification", e => {
        console.log('here');
    });

    Echo.private(`messages.${userId}`).listen(".new-message", messagesChannelEvent);
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

    date = new Date(
        Date.UTC(
            date.getFullYear(),
            date.getMonth(),
            date.getDate(),
            date.getHours(),
            date.getMinutes(),
            date.getSeconds()
        )
    ).toLocaleDateString(window.locale, {
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

        if (!chat.classList.contains('bg-gray-200')) {
            chat.classList.add('bg-gray-100');
            document.getElementById('chat-signal-' + e.chat_id).classList.remove('hidden');
        }
    } else document.getElementById('chat-list').insertAdjacentHTML('afterbegin', `
        <a href="/chat/${e.chat_id}" id="chat-${e.chat_id}"
            class="rounded-md hover:bg-gray-200 block p-4 bg-gray-100">
            <li class="flex justify-between">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto mr-6">
                        <div id="chat-signal-${e.chat_id}"
                            class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-1 end-1 dark:border-gray-900">
                        </div>

                        <p class="text-sm font-semibold leading-6 text-gray-900">${e.from}</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">${e.message ? e.message : 'Files'}</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">\
                    <p class="text-sm leading-6 text-gray-900">${e.from_status}</p>
                    <p class="date-transform mt-1 text-xs leading-5 text-gray-500">${date}</p>
                </div>
            </li>
        </a>
    `);

    // MESSAGE lIST
    let messagesList = document.getElementById('chat-messages');
    if (messagesList && messagesList.getAttribute('data-chat_id') == e.chat_id) {
        let messageElement = ``;

        if (e.message) messageElement = messageElement + `<div class="flex justify-start">
        <div
            class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl mr-6 rounded-tr-xl">
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
            </div>

            <p class="text-sm font-normal text-gray-900 dark:text-white whitespace-pre-line">${e.message}</p>
            </div>
        </div>`;

        if (e.images.length) {
            messageElement = messageElement + `<div class="flex justify-start">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl mr-6 rounded-tr-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
                </div>
                <div class="grid gap-2 ${e.images.length > 1 ? e.images.length > 4 ? 'grid-cols-3' : 'grid-cols-2' : 'grid-cols-1'}">`;

            for (let image of e.images) {
                messageElement = messageElement + `<img src="/storage/${image}" class="rounded-lg" />`;
            }

            messageElement = messageElement + `</div></div></div>`;
        }

        if (e.files.length) {
            messageElement = messageElement + `<div class="flex justify-start">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl mr-6 rounded-tr-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
                </div>
                <div class="space-y-2">`;

            for (let file of e.files) {
                messageElement = messageElement + `<div class="bg-gray-100 p-3 rounded-lg">
                    <div class="flex items-center">
                        <div class="rounded-md overflow-hidden min-w-14 w-14 h-14 mr-4 bg-white flex items-center justify-center">
                            <svg class="w-7 h-7 text-gray-500 aria-hidden="true" fill="none" viewBox="0 0 16 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 17V2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M5 15V1m8 18v-4">
                                </path>
                            </svg>
                        </div>

                        <div>
                            <div class="text-gray-900 font-semibold mb-1">${file.name}</div>

                            <div class="flex">
                                <a class="hover:underline text-gray-500 mr-4" target="_blank"
                                    href="/document?path=${file.path}">
                                    Open
                                </a>

                                <a class="hover:underline text-gray-500" download href="/storage/${file.path}">
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