import './bootstrap';
import './date';
import './toast';
import './chat';
import './suggestions';

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
            this.models = this.models.map(model => ({
                ...model,
                original_efficiency: model.efficiency * Math.pow(
                    1000,
                    window.measurements.indexOf(model.original_measurement) - window.measurements.indexOf(model.measurement)
                ),
                original_hashrate: model.hashrate * Math.pow(
                    1000,
                    window.measurements.indexOf(model.measurement)
                )
            }));
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

    if (userId) {
        userId = userId.getAttribute('content');

        Echo.private(`notifications.${userId}`).listen(".notification", e => {
            console.log('here');
        });
    }

    _.each(document.getElementsByClassName("date-transform"), window.dateTransform);

    return;
}