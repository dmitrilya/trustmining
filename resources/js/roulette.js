export var roulette = (prizes, timeToSpin) => ({
    prizes: prizes,
    extendedPrizes: [],
    isSpinning: false,
    currentTranslateX: 0,
    wonPrize: null,
    timeToSpin: timeToSpin,
    formattedTime: '',

    cardWidth: 112,
    gap: 8,

    audioCtx: null,
    lastPlayedCardIndex: -1,
    timerInterval: null,

    init() {
        if (prizes.length > 1) {
            let weightedPool = [];
            prizes.forEach(prize => {
                const count = Math.round(prize.chance);
                for (let i = 0; i < count; i++) {
                    weightedPool.push(prize);
                }
            });

            if (weightedPool.length === 0) weightedPool = prizes;

            for (let i = weightedPool.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [weightedPool[i], weightedPool[j]] = [weightedPool[j], weightedPool[i]];
            }

            const fullPool = Array.from({ length: 4 }, () => weightedPool).flat();
            this.leftOffsetCount = 40;

            const leftBuffer = fullPool.slice(-this.leftOffsetCount);
            this.extendedPrizes = [...leftBuffer, ...fullPool];

            this.updateFormattedTime();
            this.startTimer();
        }
    },

    startTimer() {
        if (this.timerInterval) clearInterval(this.timerInterval);

        if (this.timeToSpin === 0) {
            if (!this.isClosedForToday()) setTimeout(() => {
                const modalElement = document.querySelector('[name="roulette-modal"]');
                const isModalOpen = modalElement && modalElement.getBoundingClientRect().width > 0;

                if (!isModalOpen) {
                    this.resetTapeToCenter();
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette' }));
                }
            }, 15000);
        } else {
            this.timerInterval = setInterval(() => {
                if (this.timeToSpin > 0) {
                    this.timeToSpin--;
                    this.updateFormattedTime();
                } else {
                    clearInterval(this.timerInterval);
                    this.resetTapeToCenter();
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette' }));
                }
            }, 1000);
        }
    },

    playClickSound() {
        try {
            if (!this.audioCtx) {
                this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (this.audioCtx.state === 'suspended') {
                this.audioCtx.resume();
            }

            const osc = this.audioCtx.createOscillator();
            const gain = this.audioCtx.createGain();

            osc.connect(gain);
            gain.connect(this.audioCtx.destination);

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(120, this.audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(40, this.audioCtx.currentTime + 0.04);

            gain.gain.setValueAtTime(0.15, this.audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 0.04);

            osc.start();
            osc.stop(this.audioCtx.currentTime + 0.04);
        } catch (e) {
            console.log('Audio Context не поддерживается или заблокирован');
        }
    },

    trackTicks() {
        if (!this.isSpinning) return;

        const tape = document.getElementById('roulette-tape');
        const container = tape?.parentElement;
        if (!tape || !container) return;

        const style = window.getComputedStyle(tape);
        const matrix = new WebKitCSSMatrix(style.transform);
        const currentX = matrix.m41;

        const containerWidth = container.offsetWidth;
        const cardStep = this.cardWidth + this.gap;

        const centerLinePos = (containerWidth / 2) - currentX;
        const currentCardIndex = Math.floor(centerLinePos / cardStep);

        if (currentCardIndex !== this.lastPlayedCardIndex && currentCardIndex >= 0 && currentCardIndex < this.extendedPrizes.length) {
            this.playClickSound();
            this.lastPlayedCardIndex = currentCardIndex;
        }

        requestAnimationFrame(() => this.trackTicks());
    },

    resetTapeToCenter() {
        const container = document.getElementById('roulette-tape')?.parentElement;
        if (!container) return;
        const containerWidth = container.offsetWidth;
        const initialTargetPosition = this.leftOffsetCount * (this.cardWidth + this.gap);
        this.currentTranslateX = (containerWidth / 2) - initialTargetPosition - (this.cardWidth / 2);
        this.lastPlayedCardIndex = this.leftOffsetCount;
    },

    async spinTape() {
        if (this.isSpinning || this.timeToSpin > 0) return;
        this.isSpinning = true;
        localStorage.removeItem('roulette_hide_until');

        const tape = document.getElementById('roulette-tape');
        if (tape) tape.style.transitionDuration = '0ms';
        this.resetTapeToCenter();

        await new Promise(resolve => setTimeout(resolve, 50));
        if (tape) tape.style.transitionDuration = '5000ms';

        try {
            const response = await axios.get('/roulette/spin');

            if (response.data.success) {
                this.wonPrize = response.data.prize;

                this.timeToSpin = response.data.timeToSpin || 604800;
                this.updateFormattedTime();

                const container = tape.parentElement;
                const containerWidth = container.offsetWidth;

                const minCardIndex = 220;
                const targetCardIndex = this.extendedPrizes.findIndex((p, idx) => idx >= minCardIndex && p.id === this.wonPrize.id);
                const finalIndex = targetCardIndex !== -1 ? targetCardIndex : this.extendedPrizes.findLastIndex(p => p.id === this.wonPrize.id);

                const cardStep = this.cardWidth + this.gap;
                const targetPosition = finalIndex * cardStep;

                const randomOffset = Math.floor(Math.random() * (this.cardWidth - 24)) - (this.cardWidth / 2) + 12;

                this.currentTranslateX = (containerWidth / 2) - targetPosition - (this.cardWidth / 2) + randomOffset;

                this.trackTicks();

                setTimeout(() => {
                    this.isSpinning = false;
                    this.startTimer();
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette_prize' }));
                }, 5200);
            } else {
                this.isSpinning = false;
                window.pushToastAlert(response.data.message || 'Ошибка запроса', 'error');
            }
        } catch (error) {
            this.isSpinning = false;
            window.pushToastAlert?.('Не удалось запустить рулетку', 'error');
        }
    },

    getPrizeRarityClasses(chance, index = 0) {
    const pct = parseFloat(chance);
    let config = {};
    
    // Детерминированный рандом на основе index
    const createRandom = (seed) => {
        let currentSeed = seed + 55443;
        return () => {
            currentSeed = (currentSeed * 1664525 + 1013904223) % 4294967296;
            return currentSeed / 4294967296;
        };
    };

    // Генерация топологии платы с равномерным распределением по высоте
    const generateCircuitSvg = (cardIndex) => {
        const rand = createRandom(cardIndex);
        let html = '';
        
        const trackCount = 20;      // 14 горизонтальных уровней (треков)
        const trackSpacing = 6.5;   // Идеальный отступ между линиями
        const startYOffset = 6;
        
        // Карта занятости пространства по оси X для каждого трека
        const occupied = Array.from({ length: trackCount }, () => []);

        // Функция для проверки, свободен ли отрезок на конкретном треке
        const isSpaceFree = (track, xStart, xEnd) => {
            if (track < 0 || track >= trackCount) return false;
            return !occupied[track].some(range => 
                (xStart - 4 < range.end && xEnd + 4 > range.start)
            );
        };

        // Создаем массив индексов всех треков [0, 1, 2, ..., 13]
        const tracksOrder = Array.from({ length: trackCount }, (_, i) => i);
        
        // Перемешиваем массив треков (Fisher-Yates shuffle на основе нашего рандома),
        // чтобы гарантированно пройтись по каждому уровню высоты без случайных куч
        for (let i = tracksOrder.length - 1; i > 0; i--) {
            const j = Math.floor(rand() * (i + 1));
            [tracksOrder[i], tracksOrder[j]] = [tracksOrder[j], tracksOrder[i]];
        }

        // Делаем 42 попытки (проходим по перемешанному массиву треков по кругу)
        for (let i = 0; i < 62; i++) {
            const startTrack = tracksOrder[i % trackCount]; // Выбираем трек из сбалансированного списка
            const startX = Math.floor(rand() * 55); 
            
            // Длина первого горизонтального участка
            const segment1 = rand() > 0.4 ? (Math.floor(rand() * 12) + 4) : (Math.floor(rand() * 25) + 12);
            const breakX1 = startX + segment1;

            if (breakX1 > 90 || !isSpaceFree(startTrack, startX, breakX1)) continue;

            // Определяем излом: прыгаем на 1 или 2 трека вверх/вниз
            const trackDelta = rand() > 0.5 ? 1 : 2;
            const dir = rand() > 0.5 ? 1 : -1;
            const endTrack = startTrack + (dir * trackDelta);
            
            // Строгая длина диагонали под 45 градусов
            const diagWidth = trackDelta * trackSpacing; 
            const breakX2 = breakX1 + diagWidth;
            
            if (breakX2 > 95 || endTrack < 0 || endTrack >= trackCount) continue;

            // Длина финального участка с высоким контрастом
            const lengthRoll = rand();
            let segment2 = 0;
            if (lengthRoll > 0.7) {
                segment2 = Math.floor(rand() * 8) + 3; // Очень короткий хвост
            } else if (lengthRoll > 0.3) {
                segment2 = Math.floor(rand() * 20) + 15; // Средний хвост
            } else {
                segment2 = Math.floor(rand() * 40) + 35; // Длинный сквозной хвост
            }
            
            const endX = Math.min(100, breakX2 + segment2);

            // Проверяем доступность пути для конечного трека
            if (isSpaceFree(endTrack, breakX1, endX)) {
                
                // Фиксируем занятое пространство
                occupied[startTrack].push({ start: startX, end: breakX1 });
                occupied[endTrack].push({ start: breakX1, end: endX });

                const y1 = startYOffset + (startTrack * trackSpacing);
                const y2 = startYOffset + (endTrack * trackSpacing);

                // Отрисовываем ломаную линию
                const path = `M ${startX} ${y1} L ${breakX1} ${y1} L ${breakX2} ${y2} L ${endX} ${y2}`;
                const op = (rand() * 0.2 + 0.35).toFixed(2);
                
                html += `<path d="${path}" fill="none" stroke="var(--pattern-color)" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" opacity="${op}" />`;

                // Ставим кружки-контакты
                if (segment2 < 12 || rand() > 0.3) {
                    html += `<circle cx="${endX}" cy="${y2}" r="1.3" fill="#0b0f19" stroke="var(--pattern-color)" stroke-width="0.8" opacity="0.8" />`;
                }
                if (startX > 5 && rand() > 0.4) {
                    html += `<circle cx="${startX}" cy="${y1}" r="1.2" fill="var(--pattern-color)" opacity="0.75" />`;
                }
            }
        }
        return html;
    };

    // Настройка цветов и стилей редкости
    if (pct <= 3) {
        config = {
            card: 'bg-gradient-to-b from-red-800/40 to-red-900/20 dark:to-slate-900 border-red-500/60 shadow-md',
            badge: 'bg-red-500 text-white',
            glow: 'shadow-[0_0_20px_rgba(239,68,68,0.25)]',
            patternColor: '#ef4444'
        };
    } else if (pct <= 8) {
        config = {
            card: 'bg-gradient-to-b from-amber-800/40 to-amber-900/10 dark:to-slate-900 border-amber-500/50 shadow-md',
            badge: 'bg-amber-500 text-white',
            glow: 'shadow-[0_0_15px_rgba(217,70,239,0.2)]',
            patternColor: '#d946ef'
        };
    } else if (pct <= 25) {
        config = {
            card: 'bg-gradient-to-b from-indigo-800/40 to-indigo-900/10 dark:to-slate-900 border-indigo-500/50 shadow-md',
            badge: 'bg-indigo-500 text-white',
            glow: 'shadow-[0_0_12px_rgba(99,102,241,0.15)]',
            patternColor: '#6366f1'
        };
    } else {
        config = {
            card: 'bg-white shadow-md dark:bg-slate-900 border-slate-500 dark:border-slate-950',
            badge: 'bg-slate-500 dark:bg-slate-950',
            glow: '',
            patternColor: '#475569'
        };
    }
    
    config.circuitHtml = generateCircuitSvg(index);
    return config;
},

    updateFormattedTime() {
        if (this.timeToSpin <= 0) {
            this.formattedTime = '';
            return;
        }
        const days = Math.floor(this.timeToSpin / (3600 * 24));
        const hours = Math.floor((this.timeToSpin % (3600 * 24)) / 3600);
        const minutes = Math.floor((this.timeToSpin % 3600) / 60);
        const seconds = Math.floor(this.timeToSpin % 60);
        let result = '';
        if (days > 0) result += `${days}д `;
        result += `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        this.formattedTime = result;
    },

    closeRoulette() {
        const now = new Date();
        const endOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59, 999);
        if (this.timeToSpin == 0) localStorage.setItem('roulette_hide_until', endOfDay.getTime().toString());
    },

    isClosedForToday() {
        const hideUntil = localStorage.getItem('roulette_hide_until');
        if (!hideUntil) return false;
        return Date.now() < parseInt(hideUntil, 10);
        console.log(Date.now());
        console.log(parseInt(hideUntil, 10));
    }
});

document.querySelectorAll('.download-tg-ids').forEach(button => {
    button.addEventListener('click', async function (e) {
        e.preventDefault();

        const url = this.getAttribute('data-url');
        if (!url) return;

        this.disabled = true;
        this.style.opacity = '0.5';

        try {
            const response = await axios.get(url, { responseType: 'blob' });

            const disposition = response.headers['content-disposition'];
            let fileName = 'tg_ids.txt';
            if (disposition && disposition.match(/filename="(.+?)"/)) {
                fileName = disposition.match(/filename="(.+?)"/)[1];
            }

            const blob = new Blob([response.data], { type: 'text/plain' });
            const downloadUrl = window.URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = downloadUrl;
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();

            document.body.removeChild(link);
            window.URL.revokeObjectURL(downloadUrl);

        } catch (error) {
            let errorMessage = 'Не удалось скачать файл.';

            if (error.response && error.response.data instanceof Blob) {
                try {
                    const textError = await error.response.data.text();
                    const jsonError = JSON.parse(textError);

                    if (jsonError.message) errorMessage = jsonError.message;
                } catch (parseError) {
                    console.error('Ошибка парсинга ответа сервера:', parseError);
                }
            }

            window.pushToastAlert(errorMessage, 'error');
        } finally {
            this.disabled = false;
            this.style.opacity = '1';
        }
    });
});