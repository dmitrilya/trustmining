import Alpine from 'alpinejs';
window.Alpine = Alpine;
window.now = Date.now();
window.dateDiffs = {
    '1d': now - 86400000,
    '1dbefore': now - (86400000 * 2),
    '3d': now - (86400000 * 3),
    '3dbefore': now - (86400000 * 6),
    '1w': now - (86400000 * 7),
    '1wbefore': now - (86400000 * 14),
    '1m': now - (86400000 * 30),
    '1mbefore': now - (86400000 * 60),
    '3m': now - (86400000 * 90),
    '3mbefore': now - (86400000 * 180),
    '6m': now - (86400000 * 180),
    '6mbefore': now - (86400000 * 360),
    '1y': now - (86400000 * 365),
    '1ybefore': now - (86400000 * 730),
    '3y': now - (86400000 * 1095),
    '3ybefore': now - (86400000 * 2190),
    'all': null
};

document.addEventListener('alpine:initialized', () => {
    const sendHeight = () => {
        const height = document.body.scrollHeight;
        window.parent.postMessage({
            type: 'resize-difficulty',
            height: height
        }, '*');
    };

    const observer = new MutationObserver(() => {
        sendHeight();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true
    });

    sendHeight();

    window.addEventListener('resize', sendHeight);
});

Alpine.start();