export var votingWidget = (url, type, l) => ({
    loading: false,
    voted: false,
    isError: false,
    message: '',
    // Объект для отслеживания счетчиков конкретных кандидатов на одной странице
    votes: {},
    buttonTexts: {},

    init() {
        // Проверяем общую куку голосования для этой номинации (категории)
        if (localStorage.getItem(`voted_${url}`)) {
            this.voted = true;
        }
    },

    // Переносим id кандидата в аргумент метода нажатия кнопки
    async submitVote(id) {
        if (this.voted || this.loading) return;

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
                    voteable_id: id, // динамический ID
                    voteable_type: type, // общий для списка
                    fingerprint: fingerprint
                })
            });

            const r = await response.json();

            if (response.ok) {
                this.voted = true;
                this.message = r.message;
                localStorage.setItem(`voted_${url}`, '1');
                
                // Динамически увеличиваем счетчик локально для отрендеренной карточки
                if (this.votes[id] !== undefined) this.votes[id]++;
            } else {
                this.isError = true;
                this.message = r.message || l['Network error. Please try again'];
                
                if (response.status === 422 && r.reason == 'already participated') {
                    this.voted = true;
                    localStorage.setItem(`voted_${url}`, '1');
                }
            }
        } catch (e) {
            this.isError = true;
            this.message = l['Network error. Please try again'];
        } finally {
            this.loading = false;
        }
    },

    // Вспомогательный хелпер для определения текста кнопки у каждой карточки
    getButtonText(id) {
        if (this.voted || localStorage.getItem(`voted_${url}`)) {
            return l['Vote counted'];
        }
        return l['Vote'];
    }
});
