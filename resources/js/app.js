import './bootstrap';
import './date';
import './toast';
import './chat';
import './suggestions';
import './format';
import './broadcast';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

window.Alpine = Alpine;

window.measurements = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];

document.addEventListener('alpine:init', () => {
    Alpine.data('modelsData', () => ({
        models: [],
        sourceModels: [],
        search: '',
        algo: null,
        sortCol: null,
        sortAsc: true,
        async init() {
            let resp = await fetch(window.location.origin + window.location.pathname + '/get-models');
            this.models = await resp.json();
            this.sourceModels = this.models;
        },
        sort(col, asc = true) {
            if (this.sortCol === col) this.sortAsc = !this.sortAsc;
            else this.sortAsc = asc;
            this.sortCol = col;
            this.models.sort((a, b) => {
                if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
                if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
                return 0;
            });
        },
        filter(algo, search) {
            this.algo = algo;
            this.search = search.toLowerCase();
            this.models = this.sourceModels.filter(
                model => (!this.algo || this.algo && model.algorithm == this.algo) && model.name.toLowerCase().includes(this.search)
            );
        },
    }))
});

Alpine.start();

window.like = function (type, id) {
    axios.post('/like', { likeableType: 'App\\Models\\' + type, likeableId: id }).then(r => {
        if (!r.data.success) pushToastAlert(r.data.message, "error");
    });
}

window.toggleHidden = function (adId) {
    return axios.put('/ads/' + adId + '/toggle-hidden').then(r => {
        if (!r.data.success) {
            window.pushToastAlert(r.data.message, 'error');

            return false;
        }

        return true;
    });
}

window.scrollBottom = function (el) {
    el.scrollTo(0, el.scrollHeight);
}

window.sendReview = function (form) {
    const data = new FormData(form);

    if (!data.get('rating')) return window.pushToastAlert('Необходимо поставить оценку', 'error');

    axios.post('/reviews/store', data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });

    form.nextElementSibling.style.display = 'flex';
    form.remove();
}

window.checkNotifications = function () {
    let signal = document.getElementById('notifications-signal');
    if (signal && (!signal.style.opacity || signal.style.opacity != 0)) {
        signal.style.opacity = 0;
        axios.get('/profile/notifications/check');
    }
}

window.onload = function () {
    let userId = document.querySelector("meta[name='user-id']");

    /*setTimeout(() => window.messagesChannelEvent({
        chat_id: 10000000,
        message: 'qwe sadljfh asodf hy2803yt hoW;EUH ',
        images: ["chat/image_10000003_0_1752072789.webp"],
        files: [{ "name": "Ustav", "path": "chat/file_10000004_0_1752072902.doc" }],
        from: 'asd',
        from_status: 'Частное лицо',
        created_at: '2025-07-09 14:45:14'
    }), 2000);*/

    if (userId) window.listenBroadcast(userId);

    _.each(document.getElementsByClassName("date-transform"), window.dateTransform);

    return;
}