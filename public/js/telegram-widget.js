(function (window) {
    function addEvent(el, event, handler) {
        if (el.addEventListener) {
            el.addEventListener(event, handler);
        } else {
            el.attachEvent('on' + event, handler);
        }
    }

    function haveTgAuthResult() {
        try {
            const match = location.hash.match(/[#?&]tgAuthResult=([A-Za-z0-9\-_=/+]*)$/);

            if (!match) return false;

            location.hash = location.hash.replace(match[0], '');

            let data = match[1]
                .replace(/-/g, '+')
                .replace(/_/g, '/');

            while (data.length % 4) {
                data += '=';
            }

            return JSON.parse(atob(data));
        } catch (e) {
            return false;
        }
    }

    const TelegramLogin = {
        popup: null,

        auth(options, callback) {
            const botId = parseInt(options.bot_id);

            if (!botId) {
                throw new Error('Bot id required');
            }

            const width = 550;
            const height = 470;

            const left = Math.max(0, (screen.width - width) / 2);
            const top = Math.max(0, (screen.height - height) / 2);

            const origin =
                location.origin ||
                location.protocol + '//' + location.hostname;

            const popupUrl =
                'https://oauth.telegram.org/auth' +
                '?bot_id=' + encodeURIComponent(botId) +
                '&origin=' + encodeURIComponent(origin) +
                '&return_to=' + encodeURIComponent(location.href);

            const popup = window.open(
                popupUrl,
                'telegram_oauth',
                `width=${width},height=${height},left=${left},top=${top}`
            );

            this.popup = popup;

            const onMessage = (event) => {
                try {
                    const data = JSON.parse(event.data);

                    if (
                        event.source === popup &&
                        data.event === 'auth_result'
                    ) {
                        callback(data.result);

                        window.removeEventListener('message', onMessage);
                    }
                } catch (e) { }
            };

            addEvent(window, 'message', onMessage);

            const authResult = haveTgAuthResult();

            if (authResult) {
                callback(authResult);
            }
        }
    };

    window.TelegramLogin = TelegramLogin;
})(window);