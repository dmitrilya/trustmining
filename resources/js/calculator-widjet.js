(function () {
    const me = document.currentScript;

    function getParentTheme() {
        if (document.documentElement.classList.contains('dark') || document.body.classList.contains('dark')) return 'dark';
        else if (document.documentElement.classList.contains('light') || document.body.classList.contains('light')) return 'light';

        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) return 'dark';

        const attributeTheme = me.getAttribute('data-theme');
        if (attributeTheme === 'dark' || attributeTheme === 'light') return attributeTheme;

        return 'light';
    }

    const theme = getParentTheme();
    const blocks = me.getAttribute('data-blocks') || 'additional-params,coins,characteristics,currency';
    const tariffs = me.getAttribute('data-tariffs') || '[]';
    const model = me.getAttribute('data-model') || 'antminer-l9';
    const version = me.getAttribute('data-version') || '17';
    const parentUrl = window.location.href;

    const widgetUrl = `https://trustmining.ru/api/calculator-widjet?blocks=${encodeURIComponent(blocks)}&theme=${theme}&tariffs=${tariffs}&model=${model}&version=${version}&parent_url=${encodeURIComponent(parentUrl)}`;

    const iframe = document.createElement('iframe');
    iframe.title = 'Trust Mining Calculator';
    iframe.src = widgetUrl;
    iframe.style.width = '100%';
    iframe.style.border = 'none';
    iframe.style.overflow = 'hidden';
    iframe.style.display = 'block';

    me.parentNode.insertBefore(iframe, me.nextSibling);

    const observer = new MutationObserver(() => {
        if (iframe.contentWindow) iframe.contentWindow.postMessage({ type: 'THEME_CHANGE', theme: getParentTheme() }, '*');
    });

    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (iframe.contentWindow) iframe.contentWindow.postMessage({ type: 'THEME_CHANGE', theme: getParentTheme() }, '*');
    });

    window.addEventListener('message', function (event) {
        if (event.data && event.data.type === 'resize-calculator') iframe.style.height = event.data.height + 'px';
    }, false);
})();
