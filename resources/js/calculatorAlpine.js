const COEF = Object.freeze({
    day: 1,
    month: 30,
    year: 365
});

const BRACKETS = Object.freeze([
    [50000000, 0.22, 9402000],
    [20000000, 0.20, 3402000],
    [5000000, 0.18, 702000],
    [2400000, 0.15, 312000],
    [0, 0.13, 0]
]);

const round2 = value => Math.round(value * 100) / 100;

export var calculatorAlpine = (algorithms, firmwares, selVersion, selModel, fee, taxEnabled, rModel, rub, l) => ({
    algorithms: algorithms,
    firmwares: firmwares,

    currency: 'RUB',
    view: 'month',
    tariff: 5,
    version: {
        ...selVersion,
        n: selModel.n,
        ns: selModel.s,
        b: selModel.b,
        bs: selModel.bs,
        r: selModel.r,
        ra: selModel.ra
    },
    availableFirmwares: [],
    firmware: null,
    profitNumber: 0,
    fee: fee,
    count: 1,
    uptime: 99.7,
    taxEnabled: taxEnabled,
    taxType: 'ip', // person / ip / legal
    difficultyGrowth: 0,

    hashrate: selVersion.h,
    efficiency: selVersion.e,

    profit: 0,
    dailyIncome: 0,
    dailyConsumption: 0,
    dailyProfit: 0,
    minPriceUSDT: null,
    dailyTax: 0,
    taxHelp: '',
    incPercent: 33.33,
    expPercent: 33.33,
    taxPercent: 33.33,
    paybackPeriod: null,
    momentRating: null,

    init() {
        this.momentRating = this.version.ra;
        this.recalculateAll();

        this.$watch('version', () => {
            if (this.firmware) this.firmware = null;
            else this.recalculateAll();
        });

        this.$watch('currency, view, tariff, taxEnabled, taxType, count, uptime, profitNumber, firmware', () => {
            this.recalculateAll();
        });

        if (rModel) axios.post('/view/store', { viewable_type: 'asic-model', viewable_id: selModel.i });
    },

    sortFirmwares(algoProfit, isRub, isCompany, vp, minPriceRubRounded, dailyProfit) {
        let availableFirmwares = this.firmwares.filter(f => f.v == this.version.i);

        if (availableFirmwares.length) availableFirmwares = availableFirmwares.map(f => {
            let up = 0;
            const fwProfit = algoProfit * f.h * this.version.c;
            const fwDailyIncomeOne = (fwProfit * (100 - this.fee) * this.uptime / 10000);
            const fwDailyIncomeCurrency = fwDailyIncomeOne * this.count / (isRub ? rub : 1);

            const fwDailyConsumptionOne = f.e * f.h / 1000 * this.tariff * 24 * this.uptime / 100;
            const fwDailyConsumptionCurrency = (fwDailyConsumptionOne * this.count) * (!isRub ? rub : 1);

            let fwDailyProfit = fwDailyIncomeCurrency - fwDailyConsumptionCurrency;

            if (this.taxEnabled) {
                let fwCryptoTaxProfit = (fwDailyIncomeOne - fwDailyConsumptionOne * rub) * this.count / rub;
                if (isCompany && vp) {
                    const fwAmortization = round2(minPriceRubRounded * this.count / 1095);
                    fwCryptoTaxProfit -= (fwAmortization / this.count);
                }

                let fwDailyTax = 0;
                if (fwCryptoTaxProfit > 0) {
                    if (this.taxType == 'person' || this.taxType == 'ip') {
                        const fwYearProfit = fwCryptoTaxProfit * 365;
                        const matchedBracket = BRACKETS.find(([limit]) => fwYearProfit > limit);
                        fwDailyTax = ((fwYearProfit - matchedBracket[0]) * matchedBracket[1] + matchedBracket[2]) / 365;
                    } else {
                        fwDailyTax = fwCryptoTaxProfit * 0.25;
                    }
                }

                const fwDailyTaxCurrency = fwDailyTax * (!isRub ? rub : 1);
                fwDailyProfit -= fwDailyTaxCurrency;
            }

            if (dailyProfit > 0 && fwDailyProfit > dailyProfit) {
                up = Math.round(((fwDailyProfit - dailyProfit) / dailyProfit) * 100);
            } else if (dailyProfit <= 0 && fwDailyProfit > 0) {
                up = 100;
            }

            return {
                ...f,
                up: up
            };
        }).sort((a, b) => b.up - a.up);


        this.availableFirmwares = availableFirmwares;
    },

    recalculateAll() {
        this.hashrate = this.firmware != null ? this.firmware.h : this.version.h;
        this.efficiency = this.firmware != null ? this.firmware.e : this.version.e;
        const isRub = this.currency == 'RUB';
        const isCompany = this.taxType == 'ip' || this.taxType == 'legal';
        const algoProfit = this.algorithms[this.version.a].p[this.profitNumber].p;
        const vp = this.version.p;

        const profit = algoProfit * this.hashrate * this.version.c;
        const dailyIncomeOne = (profit * (100 - this.fee) * this.uptime / 10000);
        const dailyIncome = dailyIncomeOne * this.count;
        const dailyIncomeCurrency = dailyIncome / (isRub ? rub : 1);
        this.dailyIncome = round2(dailyIncomeCurrency * COEF[this.view]);
        const dailyConsumptionOne = this.efficiency * this.hashrate / 1000 * this.tariff * 24 * this.uptime / 100;
        const dailyConsumption = dailyConsumptionOne * this.count;
        const dailyConsumptionCurrency = dailyConsumption * (!isRub ? rub : 1);
        this.dailyConsumption = round2(dailyConsumptionCurrency * COEF[this.view]);
        let dailyProfit = dailyIncomeCurrency - dailyConsumptionCurrency;
        let dailyProfitOneUSDT = dailyIncomeOne - dailyConsumptionOne * rub;

        this.minPriceUSDT = vp ? (!this.taxEnabled || this.version.v ? vp : vp * 1.2) : null
        const minPriceRubRounded = Math.round(this.minPriceUSDT / rub);
        let dailyTax = 0;
        this.taxHelp = '';

        if (this.taxEnabled) {
            let taxHelp = [];
            let cryptoTaxProfit = dailyProfitOneUSDT * this.count / rub;
            let amortization = 0;

            if (isCompany && vp) {
                amortization = round2(minPriceRubRounded * this.count / 1095);
                cryptoTaxProfit -= amortization;
                taxHelp.push(`<p class='font-sans text-slate-500 mb-1'>l['Equipment amortization']</p>`);
                taxHelp.push(`<span>${l['Price']} ${this.version.n} ${this.version.h}${this.version.m} - <span class='text-indigo-500'>${minPriceRubRounded}</span> ₽ (${l['With VAT']})</span><br>`);
                if (this.count > 1) taxHelp.push(`<span><span class='text-indigo-500'>${minPriceRubRounded}</span> * ${this.count} = <span class='indigo-500'>${minPriceRubRounded * this.count}</span></span><br>`);
                taxHelp.push(`<span><span class='text-indigo-500'>${minPriceRubRounded * this.count}</span> / 1095 (3 ${l['y']}) = <span class='text-blue-700 dark:text-blue-300'>${amortization}</span></span><br>`);
            }

            taxHelp.push(`<p class='font-sans text-slate-500 mt-1.5 mb-1'>${l['Tax base']}</p>`);
            taxHelp.push(`<span class='text-emerald-500'>${round2(dailyIncome / rub)}</span> - <span class='text-red-700 dark:text-red-500'>${round2(dailyConsumption)}</span>`);
            if (isCompany && vp) taxHelp.push(` - <span class='text-blue-700 dark:text-blue-300'>${amortization}</span>`);

            const cryptoTaxProfitRounded = round2(cryptoTaxProfit);
            taxHelp.push(` = <span class='text-yellow-300'>${cryptoTaxProfitRounded}</span>`);

            if (cryptoTaxProfit <= 0) taxHelp.push(`<p class='font-sans text-slate-500 mt-1.5'>` + (isCompany ? l['You will be able to carry forward losses to the next period of up to 10 years'] : l['Your losses are lost. You cannot carry them over to the next period']) + '</p>');
            else {
                taxHelp.push('<br>');

                if (this.taxType == 'person' || this.taxType == 'ip') {
                    const yearProfit = cryptoTaxProfit * 365;
                    const yearProfitRounded = round2(yearProfit);

                    const matchedBracket = BRACKETS.find(([limit]) => yearProfit > limit);
                    const rate = matchedBracket[1];
                    const fixed = matchedBracket[2];
                    const limitValue = matchedBracket[0];

                    const annualTax = (yearProfit - limitValue) * rate;
                    const annualTaxRounded = round2(annualTax);
                    const annualTaxFixed = fixed + annualTax;
                    const annualTaxFixedRounded = round2(annualTaxFixed);
                    dailyTax = annualTaxFixed / 365;
                    const dailyTaxRounded = round2(dailyTax);

                    if (limitValue == 0) {
                        taxHelp.push(`<p class='font-sans text-slate-500 mt-1.5 mb-1'>${l['Tax rate']} 13%</p>`);
                        taxHelp.push(`<span class='text-yellow-300'>${cryptoTaxProfitRounded}</span> * 0.13 = <span class='text-rose-600 dark:text-rose-400'>${dailyTaxRounded}</span><br>`);
                    } else {
                        taxHelp.push(`<p class='font-sans text-slate-500 mt-1.5 mb-1'>${l['Progressive scale']}</p>`);
                        taxHelp.push(`<span class='text-yellow-300'>${cryptoTaxProfitRounded}</span> * 365 = <span class='text-purple-600 dark:text-purple-400'>${yearProfitRounded}</span> (${l['per year']})<br>`);
                        taxHelp.push(`(<span class='text-purple-600 dark:text-purple-400'>${yearProfitRounded}</span> - ${limitValue}) * ${rate} = <span class='text-amber-800 dark:text-amber-200'>${annualTaxRounded}</span><br>`);
                        taxHelp.push(`${fixed} <span class='text-amber-800 dark:text-amber-200'>${annualTaxRounded}</span> = <span class='text-green-500'>${annualTaxFixedRounded}</span><br>`);
                        taxHelp.push(`<span class='text-green-500'>${annualTaxFixedRounded}</span> / 365 = <span class='text-rose-600 dark:text-rose-400'>${dailyTaxRounded}</span>`);
                    }
                } else {
                    dailyTax = cryptoTaxProfit * 0.25;
                    taxHelp.push(`<p class='font-sans text-slate-500 mt-1.5 mb-1'>${l['Tax rate']} 25%</p>`);
                    taxHelp.push(`<span class='text-yellow-300'>${cryptoTaxProfitRounded}</span> * 0.25 = <span class='text-rose-600 dark:text-rose-400'>${dailyTaxRounded}</span>`);
                }
            }

            this.taxHelp = taxHelp.join('');
        }
        const dailyTaxCurrency = dailyTax * (!isRub ? rub : 1);
        const dailyTaxOneUSDT = dailyTax / this.count * rub;
        this.dailyTax = round2(dailyTaxCurrency * COEF[this.view]);
        dailyProfit -= dailyTaxCurrency;
        dailyProfitOneUSDT -= dailyTaxOneUSDT;
        this.dailyProfit = round2(dailyProfit * COEF[this.view]);

        this.sortFirmwares(algoProfit, isRub, isCompany, vp, minPriceRubRounded, dailyProfit);

        this.paybackPeriod = vp ? dailyProfitOneUSDT > 0 ? Math.round(vp / dailyProfitOneUSDT) + ' ' + window.pluralize(Math.round(vp / dailyProfitOneUSDT), l['Days']) : '∞' : l['No data']
        const total = dailyIncomeCurrency + dailyConsumptionCurrency + dailyTaxCurrency;

        if (total > 0) {
            this.incPercent = (dailyIncomeCurrency / total) * 100;
            this.expPercent = (dailyConsumptionCurrency / total) * 100;
            this.taxPercent = (dailyTaxCurrency / total) * 100;
        } else {
            this.incPercent = this.taxEnabled ? 33.34 : 50;
            this.expPercent = this.taxEnabled ? 33.33 : 50;
            this.taxPercent = this.taxEnabled ? 33.33 : 0;
        }
    }
});