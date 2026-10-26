export var votingWidget = (url, l) => ({ // Убрали type из инициализации, так как теперь он приходит в submitVote
    loading: false,
    isError: false,
    message: '',
    votes: {},

    // Вспомогательный метод для генерации уникального ключа localStorage для каждого кандидата
    getStorageKey(type, id) {
        // Если тип voteable_type относится к прогнозам монет (coin_up или coin_down),
        // привязываем ключ строго к ID конкретной монеты.
        // Для обычных голосований (например, 'users') блокируем всю категорию целиком.
        if (type === 'coin_up' || type === 'coin_down') {
            return `voted_${url}_coin_${id}`;
        }
        return `voted_${url}`;
    },

    // Метод проверки: проголосовал ли пользователь ЗА КОНКРЕТНУЮ кнопку/карточку
    hasVoted(type, id) {
        const storageKey = this.getStorageKey(type, id);
        return localStorage.getItem(storageKey) === '1';
    },

    // Метод проверки: ЗАБЛОКИРОВАНА ли данная конкретная кнопка для нажатия
    isButtonDisabled(type, id) {
        if (this.loading) return true;

        // Если это монеты, то кнопка блокируется, только если проголосовали именно за ЭТУ монету
        if (type === 'coin_up' || type === 'coin_down') {
            return this.hasVoted('coin_up', id) || this.hasVoted('coin_down', id);
        }

        // Для хостингов кнопка блокируется, если оставлен любой голос в этой категории
        return this.hasVoted(type, id);
    },

    async submitVote(type, id) {
        // Проверяем блокировку перед отправкой, используя наш новый метод
        if (this.isButtonDisabled(type, id)) return;

        this.loading = true;
        this.message = '';
        this.isError = false;

        const fpData = [
            navigator.userAgent,
            navigator.language,
            screen.colorDepth,
            screen.width + 'x' + screen.height,
            new Date().getTimezoneOffset()
        ].join('||');

        const fingerprint = btoa(fpData).replace(/[^a-zA-Z0-9]/g, '').substring(0, 32).toLowerCase().padEnd(32, '0');

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    voteable_id: id,
                    voteable_type: type,
                    fingerprint: fingerprint
                })
            });

            const r = await response.json();
            const storageKey = this.getStorageKey(type, id);

            if (response.ok) {
                this.message = r.message;
                localStorage.setItem(storageKey, '1');

                if (this.votes[id] !== undefined) this.votes[id]++;
            } else {
                this.isError = true;
                this.message = r.message || l['Network error. Please try again'];

                if (response.status === 422 && r.reason == 'already participated') {
                    localStorage.setItem(storageKey, '1');
                }
            }
        } catch (e) {
            this.isError = true;
            this.message = l['Network error. Please try again'];
        } finally {
            this.loading = false;
        }
    },

    getButtonText(type, id) {
        if (this.isButtonDisabled(type, id)) return l['Vote counted'];
        else if (type == 'coin_up') return l['Growth'];
        else if (type == 'coin_down') return l['Depreciation'];

        return l['Vote'];
    }
});
