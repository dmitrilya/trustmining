export var roulette = () => ({
    opened: false,
    renderContent: false,
    isReady: false,
    prizes: [],
    extendedPrizes: [],
    isSpinning: false,
    currentTranslateX: 0,
    wonPrize: null,
    timeToSpin: null,
    formattedTime: '',
    isLoading: true,

    cardWidth: 112,
    gap: 8,

    audioCtx: null,
    lastPlayedCardIndex: -1,
    timerInterval: null,

    init() {
        axios.get('/roulette/prizes/get').then(response => {
            const data = response.data;

            this.prizes = data.prizes;
            this.timeToSpin = data.time_to_spin;

            let weightedPool = [];
            this.prizes.forEach(prize => {
                const count = Math.round(Number(prize.chance)) || 1;
                for (let i = 0; i < count; i++) {
                    weightedPool.push({ ...prize });
                }
            });

            if (weightedPool.length === 0) {
                weightedPool = this.prizes.map(prize => ({ ...prize }));
            }

            for (let i = weightedPool.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [weightedPool[i], weightedPool[j]] = [weightedPool[j], weightedPool[i]];
            }

            let extended = [];
            for (let meta = 0; meta < 4; meta++) {
                weightedPool.forEach(prize => {
                    extended.push({ ...prize });
                });
            }

            this.extendedPrizes = Object.freeze(extended.map((prize, i) => {
                prize.pattern_id = i % 16;
                return prize;
            }));

            this.isLoading = false;

            window.dispatchEvent(new CustomEvent('roulette-loaded', {
                detail: { timeToSpin: this.timeToSpin }
            }));

            if (this.extendedPrizes.length > 1) {
                this.updateFormattedTime();
                this.startTimer();
            }
        }).catch(error => {
            console.error('Ошибка загрузки данных рулетки:', error);
        });
    },

    startTimer() {
        if (this.timerInterval) clearInterval(this.timerInterval);

        if (this.timeToSpin === 0) {
            if (!this.isClosedForToday()) setTimeout(() => {
                const modalElement = document.querySelector('[name="roulette-modal"]');
                const isModalOpen = modalElement && modalElement.getBoundingClientRect().width > 0;

                //if (!isModalOpen && this.timeToSpin === 0) window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette' }));
            }, 15000);
        } else {
            this.timerInterval = setInterval(() => {
                if (this.timeToSpin > 0) {
                    this.timeToSpin--;
                    this.updateFormattedTime();
                } else {
                    clearInterval(this.timerInterval);
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

    async spinTape() {
        if (this.isSpinning || this.timeToSpin > 0) return;
        this.isSpinning = true;
        localStorage.removeItem('roulette_hide_until');

        const tape = document.getElementById('roulette-tape');

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
                }, 10200);
            } else {
                this.isSpinning = false;
                window.pushToastAlert(response.data.message || 'Ошибка запроса', 'error');
            }
        } catch (error) {
            this.isSpinning = false;
            window.pushToastAlert?.('Не удалось запустить рулетку', 'error');
        }
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