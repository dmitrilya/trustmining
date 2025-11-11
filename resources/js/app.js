import './bootstrap';
import './date';
import './toast';
import './chat';
import { adsStatistics } from './statistics';
import './suggestions';
import './broadcast';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

window.Alpine = Alpine;

window.measurements = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];
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
    }));

    Alpine.data('adsStatisticsData', adsStatistics);
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
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        document.body.classList.add("dark");
        document.body.classList.remove("light");
    } else {
        document.body.classList.add("light");
        document.body.classList.remove("dark");
    }

    let userId = document.querySelector("meta[name='user-id']");

    if (userId) window.listenBroadcast(userId);

    Array.from(document.getElementsByClassName("date-transform")).forEach(el => window.dateTransform(el));

    return;
}