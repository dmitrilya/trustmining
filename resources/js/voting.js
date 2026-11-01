export var votingWidget = (url, l) => ({
    loading: false,
    isError: false,
    message: '',
    votes: {},

    getStorageKey(type, id) {
        if (type === 'coin_up' || type === 'coin_down') return `voted_${url}_coin_${id}`;

        return `voted_${url}`;
    },

    hasVoted(type, id) {
        const storageKey = this.getStorageKey(type, id);
        return localStorage.getItem(storageKey) === '1';
    },

    isButtonDisabled(type, id) {
        if (this.loading) return true;

        if (type === 'coin_up' || type === 'coin_down')
            return this.hasVoted('coin_up', id) || this.hasVoted('coin_down', id);

        return this.hasVoted(type, id);
    },

    async submitVote(type, id) {
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
