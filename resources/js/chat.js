window.sendMessage = function (chatId, form) {
    const data = new FormData(form);

    if (!data.get('message') && !data.get('files[]').size && !data.get('images[]').size)
        return window.pushToastAlert('Введите сообщение или прикрепите файлы', 'error');

    const container = document.getElementById('chat-messages');
    let date = new Date().toLocaleDateString('ru', {
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    });
    let messageElement = ``;

    if (data.get('message')) messageElement = messageElement + `<div class="flex justify-end">
        <div
            class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl ml-6 rounded-tl-xl">
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
            </div>

            <p class="text-sm font-normal text-gray-900 dark:text-white whitespace-pre-line">${data.get('message')}</p>
            </div>
        </div>`;

    if (data.get('images[]').size) {
        messageElement = messageElement + `<div class="flex justify-end">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl ml-6 rounded-tl-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
                </div>
                <div class="grid gap-2 ${data.getAll('images[]').length > 1 ? data.getAll('images[]').length > 4 ? 'grid-cols-3' : 'grid-cols-2' : 'grid-cols-1'}">`;

        for (let image of data.getAll('images[]')) {
            messageElement = messageElement + `<img src="${URL.createObjectURL(image)}" class="rounded-lg" />`;
        }

        messageElement = messageElement + `</div></div></div>`;
    }

    if (data.get('files[]').size) {
        messageElement = messageElement + `<div class="flex justify-end">
            <div class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl ml-6 rounded-tl-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">${date}</span>
                </div>
                <div class="space-y-2">`;

        for (let file of data.getAll('files[]')) {
            messageElement = messageElement + `<div class="bg-gray-100 p-3 rounded-lg">
            <div class="flex items-center">
                <div class="rounded-md overflow-hidden min-w-14 w-14 h-14 mr-4 bg-white flex items-center justify-center">
                    <svg class="w-7 h-7 text-gray-500 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 16 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 17V2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M5 15V1m8 18v-4">
                        </path>
                    </svg>
                </div>

                <div>
                    <div class="text-gray-900 font-semibold mb-1">${file.name}</div>

                    <div class="flex h-4"></div>
                </div>
            </div>
        </div>`;
        }

        messageElement = messageElement + `</div></div></div>`;
    }

    container.insertAdjacentHTML('beforeend', messageElement);

    container.scrollTo(0, container.scrollHeight);

    axios.post('/chat/' + chatId + '/send', data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });

    form.querySelector('#message').value = null;
    const file = form.querySelector('#input-file-chat');
    file.value = null;
    file.dispatchEvent(new Event('change'));
    const image = form.querySelector('#input-image-chat');
    image.value = null;
    image.dispatchEvent(new Event('change'));

    return;
}