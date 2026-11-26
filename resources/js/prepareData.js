export function prepareRates() {
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
                popover.innerHTML = `<div class="text-slate-800 dark:text-slate-200 text-lg sm:text-xl font-bold whitespace-nowrap">${window.adjustRate(data.rate)} <span class="text-xs sm:text-sm">USDT</span></div>`;

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

                    el.style.overflow = 'visible';
                    el.style.width = targetWidth + 'px';
                    const targetHeight = el.scrollHeight + 4 + diffFontSize;
                    el.style.overflow = 'hidden';
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

                    if (rect.left + targetWidth > window.innerWidth) {
                        el.style.left = 'unset';
                        el.style.right = '0px';

                        el.style.alignItems = 'flex-end';
                        popover.style.alignItems = 'flex-end';
                    }

                    if (rect.top + targetHeight > window.innerHeight) {
                        el.style.top = 'unset';
                        el.style.bottom = '-2px';
                        el.style.justifyContent = 'end';

                        preview.style.order = '2';
                        popover.style.order = '1';
                        popover.style.flexDirection = 'column-reverse';
                    }

                    el.style.width = targetWidth + 'px';
                    el.style.height = targetHeight + 'px';
                    el.style.zIndex = '50';
                    el.style.fontSize = targetFontSize + 'px';
                };

                let close = () => {
                    isClosing = true;

                    el.style.height = wrapper.style.height;
                    el.style.width = wrapper.style.width;
                    el.style.zIndex = '0';
                    el.style.fontSize = initialFontSize + 'px';

                    if (leaveTimeout) clearTimeout(leaveTimeout);

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
                    }, 300);
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

export function prepareTerms() {
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