(function () {
    // 1. Находим текущий скрипт, чтобы вставить iframe сразу после него
    const me = document.currentScript;
    const widgetUrl = 'https://vash-site.ru'; // Укажите ваш URL

    // 2. Создаем iframe
    const iframe = document.createElement('iframe');
    iframe.src = widgetUrl;
    iframe.style.width = '100%';
    iframe.style.border = 'none';
    iframe.style.overflow = 'hidden';
    iframe.style.display = 'block';
    iframe.scrolling = 'no';

    // Вставляем его в DOM
    me.parentNode.insertBefore(iframe, me.nextSibling);

    // 3. Слушаем сообщения от виджета (внутри iframe)
    window.addEventListener('message', function (event) {
        // Проверка безопасности (рекомендуется)
        // if (!event.origin.includes('vash-site.ru')) return;

        if (event.data && event.data.type === 'resize-calculator') {
            iframe.style.height = event.data.height + 'px';
        }
    }, false);
})();