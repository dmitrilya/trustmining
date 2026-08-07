(function () {
    const me = document.currentScript;

    const theme = me.getAttribute('data-theme') || 'light';
    const blocks = me.getAttribute('data-blocks') || 'additional-params,coins,characteristics,currency';
    const model = me.getAttribute('data-model') || 'antminer-l9';
    const version = me.getAttribute('data-version') || '17';
    const parentUrl = window.location.href;

    const widgetUrl = `https://trustmining.ru/api/calculator-widjet?blocks=${encodeURIComponent(blocks)}&theme=${theme}&model=${model}&version=${version}&parent_url=${encodeURIComponent(parentUrl)}`;

    const iframe = document.createElement('iframe');
    iframe.src = widgetUrl;
    iframe.style.width = '100%';
    iframe.style.border = 'none';
    iframe.style.overflow = 'hidden';
    iframe.style.display = 'block';

    me.parentNode.insertBefore(iframe, me.nextSibling);

    window.addEventListener('message', function (event) {
        if (event.data && event.data.type === 'resize-calculator') {
            iframe.style.height = event.data.height + 'px';
        }
    }, false);
})();