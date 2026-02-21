import './bootstrap';
import './date';
import './toast';
import './chat';
import { adsStatistics } from './statistics';
import './suggestions';
import './broadcast';
import './insight';
import './InfiniteLoader';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)
Alpine.plugin(mask);

window.Alpine = Alpine;

window.locale = document.documentElement.lang;
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

window.calculateProfitCAGR = (dailyProfit, days, percent) => {
    if (percent == 0) return dailyProfit * days;

    let coef = 1 / Math.pow(1 + (percent / 100), 1 / 365);

    return dailyProfit * (1 - Math.pow(coef, days)) / (1 - coef);
}

Alpine.start();

window.askLocation = (errorMessage) => {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            axios.post('/location', {
                lat: position.coords.latitude,
                lon: position.coords.longitude
            }).then(r => {
                if (r.data.city) {
                    window.location.reload();
                } else pushToastAlert(r.data.error, 'error');
            });
        }, function (error) {
            document.querySelector(`meta[name='should-ask-location']`).content = false;
            pushToastAlert(errorMessage, 'error');
            axios.post('/location', {
                default: true
            });
        });
    }
}

window.like = function (type, id) {
    axios.post('/like', { likeableType: type, likeableId: id }).then(r => {
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

window.filterDouble = function (el, min, max, precision) {
    let v = el.value.replace(/,/g, '.').replace(/[^\d.]/g, '');

    let parts = v.split('.');
    if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('');

    parts = v.split('.');
    if (parts[1] && parts[1].length > precision) {
        v = parts[0] + '.' + parts[1].slice(0, precision);
    }

    if (v !== '' && !v.endsWith('.')) {
        let num = parseFloat(v);
        if (num > max) v = max;
        if (num < min) v = min;
    }

    return v.toString();
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

    if (userId) window.listenBroadcast(userId.content);

    Array.from(document.getElementsByClassName("date-transform")).forEach(el => window.dateTransform(el));
}

window.saveRange = function () {
    const sel = window.getSelection();
    if (sel.rangeCount > 0) {
        return sel.getRangeAt(0);
    }

    return null;
}

function beforeRangeManipulation(range, pre) {
    if (!range) {
        pre.focus();
        const sel = window.getSelection();
        if (sel.rangeCount > 0) range = sel.getRangeAt(0);
        else return;
    }

    const sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    return [sel, range];
}

function afterRangeManipulation(sel, range, pre) {
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);

    pre.focus();
    pre.dispatchEvent(new Event('input', { bubbles: true }));
}

window.formatPaste = function (pre, e) {
    e.preventDefault();

    const text = (e.clipboardData || window.clipboardData).getData('text/plain');
    document.execCommand('insertText', false, text);
}

window.insertEmoji = function (range, pre, emoji) {
    let selection = beforeRangeManipulation(range, pre);
    const textNode = document.createTextNode(emoji);

    selection[1].deleteContents();
    selection[1].insertNode(textNode);
    selection[1].setStartAfter(textNode);

    afterRangeManipulation(selection[0], selection[1], pre);
}

window.prepareLink = function (range, pre) {
    let selection = beforeRangeManipulation(range, pre);

    return selection[1].toString();
}

window.insertLink = function (range, pre, text, url) {
    let selection = beforeRangeManipulation(range, pre);
    const link = document.createElement('a');

    link.href = url;
    link.textContent = text || selection[1].toString() || url;
    link.target = "_blank";
    link.classList.add('underline', 'text-indigo-500', 'inline');

    selection[1].deleteContents();
    selection[1].insertNode(link);
    selection[1].setStartAfter(link);

    afterRangeManipulation(selection[0], selection[1], pre);
}

window.processVideoLink = src => {
    if (src.indexOf('vkvideo') !== -1) {
        let data = src.split('/video')[1].split('_');
        src = `https://vkvideo.ru/video_ext.php?oid=${data[0]}&id=${data[1]}`;
    } else if (src.indexOf('youtube') !== -1) src = `https://www.youtube.com/embed/${src.split('v=')[1]}`;
    else if (src.indexOf('rutube') !== -1) src = `https://rutube.ru/play/embed/${src.split('video/')[1]}`;

    return src
}

window.forumEdit = function (content) {
    content.classList.add('hidden');
    content.nextElementSibling.classList.remove('hidden');
}