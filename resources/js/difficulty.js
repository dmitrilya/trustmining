import Alpine from 'alpinejs';
window.Alpine = Alpine;

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