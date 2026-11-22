import './bootstrap';
import './date';
import './toast';
import './chat';
import { modelsData } from './modelsData';
import { calculatorAlpine } from './calculatorAlpine';
import { adsStatistics } from './statistics';
import { roulette } from './roulette';
import { hashrateConverter } from './hashrate-converter';
import { tgAuth } from './tgAuth';
import { votingWidget } from './voting';
import { search } from './search';
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
    Alpine.data('modelsData', modelsData);
    Alpine.data('calculator', calculatorAlpine);
    Alpine.data('roulette', roulette);
    Alpine.data('hashrateConverter', hashrateConverter);
    Alpine.data('tgAuth', tgAuth);
    Alpine.data('adsStatisticsData', adsStatistics);
    Alpine.data('votingWidget', votingWidget);
    Alpine.data('search', search);
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

window.addView = function (type, id) {
    if (navigator.webdriver || window.cdc_adoQpoasnfa76pfcZLmcfl_Array || window.__webdriver_evaluate) return;
    axios.post('/view/store', { viewable_type: type, viewable_id: id });
}

/**
 * @param {string|number} rate
 * @param {string} currency
 * @returns {string}
 */
window.adjustRate = function (rate, currency = 'usdt') {
    const numericRate = parseFloat(rate);

    if (isNaN(numericRate)) return '0';

    let decimals;

    if (currency === 'rub') decimals = numericRate >= 10000 ? 0 : numericRate >= 100 ? 1 : 2;
    else decimals = numericRate >= 5000 ? 1 : numericRate >= 40 ? 2 : numericRate >= 10 ? 4 : 8;

    return new Intl.NumberFormat('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }).format(numericRate);
}

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

window.vote = function (category, type, id) {
    axios.post(`voting/${category}/vote`, { voteableType: type, voteableId: id }).then(r => {
        if (!r.data.success && 'message' in r.data) {
            pushToastAlert(r.data.message, "error");
            return;
        }

        if ('message' in r.data) pushToastAlert(r.data.message, "success");
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
    let regex = precision === 0 ? /[^\d]/g : /[^\d.]/g;
    let v = el.value.replace(/,/g, '.').replace(regex, '').replace(/^0+(?=\d)/, '');

    let parts = v.split('.');
    if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('');

    if (precision > 0) {
        parts = v.split('.');
        if (parts[1] && parts[1].length > precision) {
            v = parts[0] + '.' + parts[1].slice(0, precision);
        }
    }

    if (v !== '' && !v.endsWith('.')) {
        let num = parseFloat(v);
        if (max !== undefined && max !== null && num > max) v = max;
        else if (min !== undefined && min !== null && num < min) v = min;
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

    prepareRates();
    prepareTerms();
}

window.saveRange = function () {
    const sel = window.getSelection();
    if (sel.rangeCount > 0) return sel.getRangeAt(0);

    return null;
}

function prepareRates() {
    const elements = document.querySelectorAll('.rate:not(#editor .rate)');
    const uniqueCoins = [...new Set(
        Array.from(elements).map(el => el.dataset.coin).filter(coin => coin)
    )];

    if (uniqueCoins.length === 0) return;

    axios.get('/metrics/coin/rates', {
        params: { coins: uniqueCoins }
    }).then(r => {
        const coins = r.data.coins;

        elements.forEach(el => {
            const coin = el.dataset.coin;
            const data = coins[coin];

            if (data !== undefined) {
                const change = document.createElement('span');
                change.className = data.change < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-500';
                change.innerText = ' ' + (data.change > 0 ? '+' : '') + data.change + '%';
                change.style.fontWeight = 'bold';
                el.appendChild(change);

                const origHeight = el.offsetHeight + 'px';
                const origWidth = el.offsetWidth + 'px';

                const wrapper = document.createElement('span');
                wrapper.className = 'rate-wrapper inline-block relative mx-1';
                wrapper.style.height = origHeight;
                wrapper.style.width = origWidth;
                el.before(wrapper);
                wrapper.appendChild(el);

                el.classList.add('rate-expanded', 'backdrop-blur-xl', 'absolute', 'flex', 'overflow-hidden');
                el.style.transition = 'all 0.3s ease-in-out';
                el.style.flexDirection = 'column';
                el.style.alignItems = 'flex-start';
                el.style.height = origHeight;
                el.style.width = origWidth;
                el.style.marginLeft = 0;
                el.style.marginRight = 0;
                el.style.width = origWidth;

                const targetFontSize = 16;
                const initialFontSize = parseFloat(window.getComputedStyle(el).fontSize);
                const diffFontSize = (targetFontSize - initialFontSize) * 2;

                const preview = document.createElement('span');
                preview.className = 'rate-preview inline-flex items-center gap-2';
                preview.style.setProperty('--coin-url', el.style.getPropertyValue('--coin-url'));

                while (el.firstChild) {
                    preview.appendChild(el.firstChild);
                }

                el.appendChild(preview);

                const popover = document.createElement('div');
                popover.className = 'flex w-full gap-2';
                popover.style.flexDirection = 'column';
                popover.style.alignItems = 'flex-start';
                popover.innerHTML = `<div class="text-slate-800 dark:text-slate-200 text-lg sm:text-xl font-bold whitespace-nowrap">${data.rate} <span class="text-xs sm:text-sm">USDT</span></div>`;

                if (data.history && data.history.length > 1) popover.innerHTML += `
                    <div class="w-full flex items-center justify-center h-12">
                        <svg class="sparkline" width="${window.innerWidth > 380 ? 158 : 140}" height="30" stroke-width="2" stroke="currentColor" fill="none"></svg>
                    </div>`;

                popover.innerHTML += `
                    <a class="block w-full no-underline" href="/metrics/coin/${data.name.toLowerCase()}/rate">
                        <button type="button" class="w-full flex items-center justify-center px-4 py-1.5 rounded-lg font-extrabold text-xxs sm:text-xs text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow hover:shadow-md hover:-translate-y-0.5 focus:outline-none transition ease-in-out duration-100 bg-white/40 dark:bg-slate-900/40 border-0 ring-1 ring-inset ring-slate-300 dark:ring-slate-700 shadow-logo-color hover:shadow-logo-color">
                            ${__('Details')}
                        </button>
                    </a>`;

                el.appendChild(popover);

                let isClosing = false;
                let leaveTimeout = null;

                let open = () => {
                    if (isClosing) return;
                    if (leaveTimeout) clearTimeout(leaveTimeout);

                    const rect = wrapper.getBoundingClientRect();
                    const targetWidth = window.innerWidth > 380 ? 180 : 160;
                    
                    // 1. Измеряем точную высоту контента карточки
                    el.style.overflow = 'visible';
                    el.style.width = targetWidth + 'px';
                    const targetHeight = el.scrollHeight + 4 + diffFontSize;
                    el.style.overflow = 'hidden';

                    // 2. Ставим базовые настройки (вниз и вправо)
                    el.style.left = '0px';
                    el.style.right = 'unset';
                    el.style.top = '2px';
                    el.style.bottom = 'unset';

                    el.style.flexDirection = 'column';
                    el.style.alignItems = 'flex-start';
                    el.style.justifyContent = 'start';
                    preview.style.order = '1';
                    popover.style.order = '2';
                    popover.style.flexDirection = 'column';
                    popover.style.alignItems = 'flex-start';

                    // 3. ЕСЛИ НЕ ВЛАЗИТ СПРАВА — переключаем привязку на правый край wrapper
                    if (rect.left + targetWidth > window.innerWidth) {
                        el.style.left = 'unset';
                        el.style.right = '0px'; // Коробка жестко встает справа и будет расти ВЛЕВО
                        
                        el.style.alignItems = 'flex-end';
                        popover.style.alignItems = 'flex-end';
                    }

                    // 4. ЕСЛИ НЕ ВЛАЗИТ СНИЗУ — переключаем привязку на нижний край wrapper
                    if (rect.top + targetHeight > window.innerHeight) {
                        el.style.top = 'unset';
                        el.style.bottom = '-2px'; // Коробка жестко встает снизу и будет расти ВВЕРХ
                        el.style.justifyContent = 'end';

                        preview.style.order = '2';
                        popover.style.order = '1';
                        popover.style.flexDirection = 'column-reverse';
                    }

                    // 5. ЗАПУСКАЕМ ИЗМЕНЕНИЕ РАЗМЕРОВ
                    el.style.width = targetWidth + 'px';
                    el.style.height = targetHeight + 'px';
                    el.style.zIndex = '50';
                    el.style.fontSize = targetFontSize + 'px';
                };

                let close = () => {
                    isClosing = true;

                    // Возвращаем физические размеры плашки обратно.
                    // Так как el.style.right или bottom НЕ ТРОГАЮТСЯ в этот момент, 
                    // карточка плавно сжимается ИМЕННО в ту сторону, откуда открылась!
                    el.style.height = wrapper.style.height;
                    el.style.width = wrapper.style.width;
                    el.style.zIndex = '0';
                    el.style.fontSize = initialFontSize + 'px';

                    if (leaveTimeout) clearTimeout(leaveTimeout);

                    // СБРОС КООРДИНАТ В ДЕФОЛТ ПЕРЕНЕСЕН СТРОГО СЮДА!
                    // Он сработает через 300мс, когда анимация сжатия ПОЛНОСТЬЮ завершилась
                    // и элемент уже принял размеры маленького wrapper. Скачок будет не виден глазу.
                    leaveTimeout = setTimeout(() => {
                        if (el.style.height === wrapper.style.height) {
                            el.style.bottom = '';
                            el.style.right = '';
                            el.style.top = '2px';
                            el.style.left = '0px';
                            
                            el.style.flexDirection = 'column';
                            el.style.alignItems = 'flex-start';
                            el.style.justifyContent = '';

                            preview.style.order = '';
                            popover.style.order = '';
                            popover.style.flexDirection = 'column';
                            popover.style.alignItems = 'flex-start';
                        }
                        isClosing = false;
                    }, 300); // 300ms должно в точности совпадать с временем вашего CSS transition
                };

                wrapper.addEventListener('mouseenter', open);
                wrapper.addEventListener('mouseleave', close);
                wrapper.addEventListener('click', (e) => {
                    if (e.target.closest('a') || e.target.closest('button')) return;

                    e.stopPropagation();

                    const isCurrentClosed = (parseInt(el.style.height) === wrapper.offsetHeight || !el.style.height);

                    if (isCurrentClosed) {
                        document.querySelectorAll('.rate-wrapper').forEach(otherWrapper => {
                            if (otherWrapper !== wrapper) {
                                otherWrapper.dispatchEvent(new MouseEvent('mouseleave', { bubbles: true }));
                            }
                        });
                        open();
                    } else close();
                });

                if (!window.rateOutsideClickRegistered) {
                    window.rateOutsideClickRegistered = true;
                    document.addEventListener('click', () => {
                        document.querySelectorAll('.rate-wrapper[data-clicked="true"]').forEach(openW => {
                            openW.dataset.clicked = 'false';
                            openW.dispatchEvent(new MouseEvent('mouseleave', { bubbles: true }));
                        });
                    });
                }

                const svg = popover.querySelector('.sparkline');
                if (svg && data.history && data.history.length > 1) {
                    buildAndAnimateChart(el, svg, data.history);
                }
            }
        });
    });
}

function buildAndAnimateChart(parentElement, svg, history) {
    const width = window.innerWidth > 380 ? 158 : 140;
    const height = 28;
    const max = Math.max(...history);
    const min = Math.min(...history);
    const range = max - min === 0 ? 1 : max - min;

    const points = history.map((val, index) => {
        return {
            x: (index / (history.length - 1)) * width,
            y: (height - ((val - min) / range) * height) + 1
        };
    });

    let d = '';
    if (points.length > 0) {
        d = `M ${points[0].x} ${points[0].y}`;

        for (let i = 0; i < points.length - 1; i++) {
            const p0 = points[i === 0 ? i : i - 1];
            const p1 = points[i];
            const p2 = points[i + 1];
            const p3 = points[i + 2 === points.length ? i + 1 : i + 2];

            const cp1x = p1.x + (p2.x - p0.x) / 6;
            const cp1y = p1.y + (p2.y - p0.y) / 6;
            const cp2x = p2.x - (p3.x - p1.x) / 6;
            const cp2y = p2.y - (p3.y - p1.y) / 6;

            d += ` C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${p2.x} ${p2.y}`;
        }
    }

    svg.innerHTML = `<path d="${d}" stroke="oklch(51.1% .262 276.966)" stroke-linecap="round" stroke-linejoin="round" />`;

    const path = svg.querySelector('path');
    const length = path.getTotalLength();

    path.style.strokeDasharray = length;
    path.style.strokeDashoffset = length;
    path.style.transition = 'stroke-dashoffset 0.8s ease-in-out';

    parentElement.addEventListener('mouseenter', () => {
        path.style.strokeDashoffset = '0';
    }, { once: true });
}

function prepareTerms() {
    window.terms = window.terms || {};

    let activeTerm = null;
    let popup = null;
    let hideTimeout = null;
    let currentFetchController = null;

    function createPopup() {
        if (popup) return popup;

        popup = document.createElement('div');
        popup.className = ['tm-wiki-popup', 'fixed', 'z-50', 'hidden', 'w-80', 'max-w-xs', 'rounded-xl', 'bg-white/40', 'dark:bg-slate-900/40', 'border', 'border-slate-300', 'dark:border-slate-700', 'backdrop-blur-xl', 'p-2', 'sm:p-3', 'shadow-xl'].join(' ');
        popup.innerHTML = `
            <div class="tm-wiki-popup-name font-semibold text-slate-800 dark:text-slate-200"></div>
            <div class="tm-wiki-popup-caption mt-1 text-xs leading-5 text-slate-600 dark:text-slate-400"></div>
            <a
                href="#" target="_blank"
                class="tm-wiki-popup-link mt-3 inline-block text-sm font-medium text-indigo-500 hover:text-indigo-600"
            >
                ${typeof __ === 'function' ? __('Details') : 'Details'} →
            </a>
        `;

        document.body.appendChild(popup);

        popup.addEventListener('mouseenter', () => { cancelHidePopup(); });
        popup.addEventListener('mouseleave', () => { scheduleHidePopup(); });

        return popup;
    }

    function positionPopup(element) {
        if (!popup || popup.classList.contains('hidden')) return;

        const rect = element.getBoundingClientRect();
        const popupWidth = popup.offsetWidth;
        const popupHeight = popup.offsetHeight;
        const gap = 8;
        const viewportPadding = 12;
        const windowWidth = document.documentElement.clientWidth;
        const windowHeight = document.documentElement.clientHeight;

        let left = rect.left + (rect.width / 2) - (popupWidth / 2);
        let top = rect.bottom + gap;

        if (left < viewportPadding) left = viewportPadding;
        if (left + popupWidth > windowWidth - viewportPadding) left = windowWidth - popupWidth - viewportPadding;
        if (top + popupHeight > windowHeight - viewportPadding) top = rect.top - popupHeight - gap;
        if (top < viewportPadding) top = viewportPadding;

        popup.style
        popup.style.left = `${left}px`;
        popup.style.top = `${top}px`;
    }

    async function showPopup(element) {
        const key = element.dataset.term;
        if (!key) return;

        activeTerm = element;
        const popupElement = createPopup();

        if (currentFetchController) currentFetchController.abort();

        if (window.terms[key]) {
            renderPopupData(key, window.terms[key]);
            return;
        }

        popupElement.querySelector('.tm-wiki-popup-name').textContent = '...';
        popupElement.querySelector('.tm-wiki-popup-caption').textContent = typeof __ === 'function' ? __('Loading...') : 'Loading...';
        popupElement.querySelector('.tm-wiki-popup-link').classList.add('hidden');
        popupElement.classList.remove('hidden');

        requestAnimationFrame(() => { positionPopup(element) });

        currentFetchController = new AbortController();
        try {
            const response = await fetch(`/wiki/dictionary/${key}/get`, {
                signal: currentFetchController.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            window.terms[key] = data;

            if (activeTerm === element) renderPopupData(key, data);
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Fetch error:', error);
                popupElement.querySelector('.tm-wiki-popup-caption').textContent = 'Error loading data.';
            }
        }
    }

    function renderPopupData(key, data) {
        if (!popup) return;
        const keyParts = key.split('/');

        popup.querySelector('.tm-wiki-popup-name').textContent = data.name || '';
        popup.querySelector('.tm-wiki-popup-caption').textContent = data.caption || '';

        const link = popup.querySelector('.tm-wiki-popup-link');
        link.href = `/wiki/dictionary/${keyParts[0]}/${keyParts[1]}`;
        link.classList.remove('hidden');

        popup.classList.remove('hidden');

        requestAnimationFrame(() => { positionPopup(activeTerm); });
    }

    function hidePopup() {
        if (currentFetchController) {
            currentFetchController.abort();
            currentFetchController = null;
        }
        if (!popup) return;

        popup.classList.add('hidden');
        activeTerm = null;
    }

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

        element.addEventListener('mouseleave', () => { scheduleHidePopup() });

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

    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') hidePopup() });

    window.addEventListener('resize', () => { if (activeTerm) positionPopup(activeTerm) });

    window.addEventListener('scroll', () => { if (activeTerm) positionPopup(activeTerm) }, { passive: true });
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