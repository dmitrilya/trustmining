export var roulette = (prizes, timeToSpin) => ({
    prizes: prizes,
    sectorAngle: 360 / prizes.length,
    isSpinning: false,
    currentRotation: 0,
    wonPrize: null,
    timeToSpin: timeToSpin,
    formattedTime: '',

    init() {
        if (prizes.length > 1) {
            this.updateFormattedTime();

            if (this.timeToSpin === 0) {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette' }));
                }, 30000);
            } else {
                let timer = setInterval(() => {
                    if (this.timeToSpin > 0) {
                        this.timeToSpin--;
                        this.updateFormattedTime();
                    } else {
                        clearInterval(timer);
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette' }));
                    }
                }, 1000);
            }
        }
    },

    updateFormattedTime() {
        if (this.timeToSpin <= 0) return;

        const days = Math.floor(this.timeToSpin / (3600 * 24));
        const hours = Math.floor((this.timeToSpin % (3600 * 24)) / 3600);
        const minutes = Math.floor((this.timeToSpin % 3600) / 60);
        const seconds = Math.floor(this.timeToSpin % 60);

        let result = '';
        if (days > 0) result += `${days}д `;
        result += `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        this.formattedTime = result;
    },

    async spinWheel() {
        if (this.isSpinning) return;
        this.isSpinning = true;

        try {
            const response = await axios.get('/roulette/spin');

            if (response.data.success) {
                const prizeIndex = this.prizes.findIndex(p => p.id === response.data.prize.id);
                const targetSectorAngle = 360 - (prizeIndex * this.sectorAngle) - (this.sectorAngle / 2);

                this.currentRotation = 1800 + targetSectorAngle;
                this.wonPrize = response.data.prize;

                setTimeout(() => {
                    this.isSpinning = false;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'roulette_prize' }));
                }, 5000);
            } else {
                this.isSpinning = false;
                window.pushToastAlert(response.data.message || 'Ошибка запроса', 'error');
            }
        } catch (error) {
            this.isSpinning = false;
            const errorMsg = error.response?.data?.message || 'Не удалось запустить рулетку';
            pushToastAlert(errorMsg, 'error');
        }
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