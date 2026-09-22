import './bootstrap';
import './date';
import './toast';
import './chat';
import { calculatorAlpine } from './calculatorAlpine';
import { adsStatistics } from './statistics';
import { roulette } from './roulette';
import { hashrateConverter } from './hashrate-converter';
import { tgAuth } from './tgAuth';
import './suggestions';
import './broadcast';
import './carousel';
import './insight';
import './InfiniteLoader';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import collapse from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect';

Alpine.plugin(mask);
Alpine.plugin(collapse)
Alpine.plugin(intersect);

window.Alpine = Alpine;

window.locale = document.documentElement.lang;
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
        algorithms: [],
        search: '',
        algo: null,
        sortCol: null,
        sortAsc: true,
        observer: null,
        pageCount: 10,
        page: 1,

        async init() {
            let resp = await fetch(window.location.origin + window.location.pathname + '/get-models');
            const data = await resp.json();

            this.sourceModels = Object.freeze(data.m);
            this.algorithms = Object.freeze(data.a);
            this.models = [...this.sourceModels];

            this.$nextTick(() => {
                this.setupObserver();
            });
        },

        sort(col, asc = true) {
            if (this.sortCol === col) this.sortAsc = !this.sortAsc;
            else this.sortAsc = asc;
            this.sortCol = col;
            this.models = [...this.models].sort((a, b) => {
                if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
                if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
                return 0;
            });

            this.page = 1;
            this.$nextTick(() => {
                this.setupObserver();
            });
        },

        filter(algo, search) {
            this.algo = algo;
            this.search = search.toLowerCase();
            this.models = this.sourceModels.filter(
                model => (!this.algo || this.algo && model.a == this.algo) && model.n.toLowerCase().includes(this.search)
            );

            this.page = 1;
            this.$nextTick(() => {
                this.setupObserver();
            });
        },

        setupObserver() {
            if (this.observer) this.observer.disconnect();

            const rows = Array.from(document.querySelectorAll('.model'));
            const lastRow = rows[rows.length - 1];

            if (!lastRow || this.pageCount * this.page >= this.models?.length) return;

            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.page++;
                        this.observer.unobserve(entry.target);

                        this.$nextTick(() => {
                            this.setupObserver();
                        });
                    }
                });
            }, {
                root: null,
                rootMargin: '200px',
                threshold: 0.1
            });

            this.observer.observe(lastRow);
        }
    }));

    Alpine.data('calculator', calculatorAlpine);

    Alpine.data('roulette', roulette);

    Alpine.data('hashrateConverter', hashrateConverter);

    Alpine.data('tgAuth', tgAuth);

    Alpine.data('adsStatisticsData', adsStatistics);
});

window.calculateProfitCAGR = (dailyProfit, days, percent) => {
    if (percent == 0) return dailyProfit * days;

    let coef = 1 / Math.pow(1 + (percent / 100), 1 / 365);

    return dailyProfit * (1 - Math.pow(coef, days)) / (1 - coef);
}

window.pluralize = function (count, trans) {
    let n = Math.abs(count) % 100;
    let n1 = n % 10;
    if (n > 10 && n < 20) return trans[2];
    if (n1 > 1 && n1 < 5) return trans[1];
    if (n1 === 1) return trans[0];
    return trans[2];
}

window.initLazyComponent = function (componentContext, breakpoint = '1024px') {
    const checkScreen = () => {
        if (window.matchMedia(`(min-width: ${breakpoint})`).matches) {
            componentContext.isXL = true;

            window.removeEventListener('resize', checkScreen);
        }
    };

    window.addEventListener('resize', checkScreen);
};

Alpine.start();

window.__ = (key) => window.Translations[key] !== undefined ? window.Translations[key] : key;

window.askLocation = (errorMessage) => {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            axios.post('/location', {
                lat: position.coords.latitude,
                lon: position.coords.longitude
            }).then(r => {
                if (!r.data.city) pushToastAlert(r.data.error, 'error');
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
    let v = el.value.replace(/,/g, '.').replace(/[^\d.]/g, '').replace(/^0+(?=\d)/, '');

    let parts = v.split('.');
    if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('');

    parts = v.split('.');
    if (parts[1] && parts[1].length > precision) {
        v = parts[0] + '.' + parts[1].slice(0, precision);
    }

    if (v !== '' && !v.endsWith('.')) {
        let num = parseFloat(v);
        if (max && num > max) v = max;
        if (min && num < min) v = min;
    }

    return v.toString();
}

window.sendReview = function (form) {
    const data = new FormData(form);

    if (!data.get('rating')) return window.pushToastAlert(__('Rating required'), 'error');

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
    document.documentElement.style.setProperty('--header-height', `${document.getElementById('head')?.offsetHeight || 0}px`);
    window.addEventListener('resize', () => document.documentElement.style.setProperty('--header-height', `${document.getElementById('head')?.offsetHeight || 0}px`));

    let userId = document.querySelector("meta[name='user-id']");

    if (userId) window.listenBroadcast(userId.content);

    Array.from(document.getElementsByClassName("date-transform")).forEach(el => window.dateTransform(el));

    prepareTerms();
}

window.saveRange = function () {
    const sel = window.getSelection();
    if (sel.rangeCount > 0) {
        return sel.getRangeAt(0);
    }

    return null;
}

function prepareTerms() {
    const terms = window.terms || {};
    console.log(terms);

    let activeTerm = null;
    let popup = null;

    function createPopup() {
        if (popup) {
            return popup;
        }

        popup = document.createElement('div');

        popup.className = ['tm-wiki-popup', 'fixed', 'z-50', 'hidden', 'w-80', 'max-w-xs', 'rounded-xl', 'bg-white/40', 'dark:bg-slate-900/40', 'border', 'border-slate-300', 'dark:border-slate-700', 'backdrop-blur-xl', 'p-2', 'sm:p-3', 'shadow-xl'].join(' ');

        popup.innerHTML = `
            <div class="tm-wiki-popup-name font-semibold text-slate-800 dark:text-slate-200"></div>
            <div class="tm-wiki-popup-caption mt-1 text-xs leading-5 text-slate-600 dark:text-slate-400"></div>
            <a
                href="#" target="_blank"
                class="tm-wiki-popup-link mt-3 inline-block text-sm font-medium text-indigo-500 hover:text-indigo-600"
            >
                ${__('Details')} →
            </a>
        `;

        document.body.appendChild(popup);

        popup.addEventListener('mouseenter', () => { cancelHidePopup(); });

        popup.addEventListener('mouseleave', () => { scheduleHidePopup(); });

        return popup;
    }

    function positionPopup(element) {
        if (!popup) {
            return;
        }

        const rect = element.getBoundingClientRect();

        const popupWidth = popup.offsetWidth;
        const popupHeight = popup.offsetHeight;

        const gap = 8;
        const viewportPadding = 12;

        let left = rect.left + (rect.width / 2) - (popupWidth / 2);
        let top = rect.bottom + gap;

        if (left < viewportPadding) {
            left = viewportPadding;
        }

        if (left + popupWidth > window.innerWidth - viewportPadding) {
            left = window.innerWidth - popupWidth - viewportPadding;
        }

        if (top + popupHeight > window.innerHeight - viewportPadding) {
            top = rect.top - popupHeight - gap;
        }

        if (top < viewportPadding) {
            top = viewportPadding;
        }

        popup.style.left = `${left}px`;
        popup.style.top = `${top}px`;
    }

    function showPopup(element) {
        const key = element.dataset.term;
        const data = terms[key];
        const keyParts = key.split('/');

        if (!data) return;

        const current = activeTerm === element;

        activeTerm = element;

        const popupElement = createPopup();

        popupElement.querySelector('.tm-wiki-popup-name').textContent = data.name || '';

        popupElement.querySelector('.tm-wiki-popup-caption').textContent = data.caption || '';

        const link = popupElement.querySelector('.tm-wiki-popup-link');

        link.href = `/wiki/dictionary/${keyParts[0]}/${keyParts[1]}`;

        popupElement.classList.remove('hidden');

        requestAnimationFrame(() => { positionPopup(element); });

        return current;
    }

    function hidePopup() {
        if (!popup) return;

        popup.classList.add('hidden');
        activeTerm = null;
    }

    let hideTimeout = null;

    function scheduleHidePopup() {
        clearTimeout(hideTimeout);

        hideTimeout = setTimeout(() => { hidePopup(); }, 150);
    }

    function cancelHidePopup() {
        clearTimeout(hideTimeout);
    }

    document.querySelectorAll('span.term[data-term]').forEach(element => {
        element.addEventListener('mouseenter', () => {
            cancelHidePopup();
            showPopup(element);
        });

        element.addEventListener('mouseleave', () => { scheduleHidePopup(); });

        element.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            cancelHidePopup();

            if (activeTerm === element && popup && !popup.classList.contains('hidden')) hidePopup();
            else showPopup(element);
        });
    });

    document.addEventListener('click', (event) => {
        if (!activeTerm) return;

        if (event.target.closest('span.term[data-term]') || event.target.closest('.tm-wiki-popup')) return;

        hidePopup();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') hidePopup();
    });

    window.addEventListener('resize', () => {
        if (activeTerm && popup && !popup.classList.contains('hidden')) positionPopup(activeTerm);
    });

    window.addEventListener('scroll', () => {
        if (activeTerm && popup && !popup.classList.contains('hidden')) positionPopup(activeTerm);
    }, { passive: true });
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