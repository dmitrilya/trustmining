const TelegramPingManager = {
    promise: null,

    check() {
        if (this.promise) return this.promise;

        this.promise = new Promise(async (resolve) => {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 1500);

            try {
                await fetch('https://telegram.org/js/telegram-widget.js', {
                    method: 'HEAD',
                    mode: 'no-cors',
                    signal: controller.signal
                });
                clearTimeout(timeoutId);
                resolve(true);
            } catch (error) {
                clearTimeout(timeoutId);
                console.warn('Telegram servers are unreachable. Probably VPN is off.');
                resolve(false);
            }
        });

        return this.promise;
    }
};

export var tgAuth = (botId) => ({
    botId: botId,
    tgWidgetLoaded: false,
    tgTimeout: false,

    async init() {
        if (!window.TelegramLogin || !window.TelegramLogin.auth) {
            this.tgWidgetLoaded = false;
            this.tgTimeout = true;
            return;
        }

        const isAvailable = await TelegramPingManager.check();

        this.tgWidgetLoaded = isAvailable;
        this.tgTimeout = true;
    },

    auth() {
        if (!this.tgWidgetLoaded) {
            console.error('Cannot auth: Telegram is unreachable');
            return;
        }

        TelegramLogin.auth({ bot_id: this.botId, request_access: true }, (data) => {
            if (data) {
                let query = Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&');
                window.location.href = 'https://trustmining.ru/tg/auth?' + query;
            } else {
                console.error('Telegram auth failed or closed');
            }
        });
    }
});
