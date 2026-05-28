window.TelegramLoader = {
    promise: null,
    controller: null,
    status: 'idle',

    load(timeoutMs = 2500) {
        if (this.promise) return this.promise;

        this.status = 'loading';
        this.controller = new AbortController();

        this.promise = new Promise((resolve, reject) => {
            const timer = setTimeout(() => {
                if (this.status === 'loading') {
                    this.controller.abort();
                    this.status = 'timeout';
                    reject(new Error('Telegram load timeout'));
                }
            }, timeoutMs);

            axios.get('https://telegram.org/js/telegram-widget.js', {
                signal: this.controller.signal,
                responseType: 'text'
            })
                .then(response => {
                    clearTimeout(timer);

                    const script = document.createElement('script');
                    script.text = response.data;
                    document.head.appendChild(script);

                    this.status = 'loaded';
                    resolve();
                })
                .catch(error => {
                    clearTimeout(timer);
                    if (axios.isCancel(error)) {
                        this.status = 'timeout';
                    } else {
                        this.status = 'error';
                    }
                    reject(error);
                });
        });

        return this.promise;
    }
};

window.tgAuth = (botId) => ({
    botId: botId,
    tgWidgetLoaded: false,
    tgTimeout: false,

    async init() {
        window.TelegramLoader.load(2500)
            .then(() => {
                this.tgWidgetLoaded = true;
                this.tgTimeout = true;
            })
            .catch(() => {
                this.tgWidgetLoaded = false;
                this.tgTimeout = true;
            });
    },

    auth() {
        Telegram.Login.auth({ bot_id: this.botId, request_access: true }, (data) => {
            if (data) {
                let query = Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&');
                window.location.href = 'https://trustmining.ru/tg/auth?' + query;
            } else {
                console.error('Telegram auth failed or closed');
            }
        });
    }
});