export var hashrateConverter = () => ({
    activeType: 'h',
    prefixes: ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z'],

    types: [
        { code: 'h', name: 'Hash (Хеши)', unit: 'H/s' },
        { code: 'sol', name: 'Sol (Солы)', unit: 'Sol/s' },
        { code: 'g', name: 'Graph (Графы)', unit: 'G/s' },
        { code: 'c', name: 'Cuckoos', unit: 'C/s' },
        { code: 'k', name: 'Key (Ключи)', unit: 'K/s' }
    ],

    values: {},

    init() {
        this.resetWithBase(1000, 'M');
    },

    changeType(typeCode) {
        this.activeType = typeCode;
        let currentField = this.prefixes.find(p => this.values[p] !== '' && !isNaN(this.cleanNumber(this.values[p]))) || '';
        let currentVal = this.cleanNumber(this.values[currentField]) || 0;
        this.updateFromField(currentVal.toString(), currentField);
    },

    resetWithBase(val, prefix) {
        this.updateFromField(val.toString(), prefix);
    },

    // 🛑 МЕТОД ФИЛЬТРАЦИИ КЛАВИАТУРЫ: Блокирует буквы и дублирующиеся разделители
    filterKey(event) {
        const key = event.key;

        // Разрешаем горячие клавиши (Ctrl+A, Ctrl+C и т.д.) и системные кнопки (BackSpace, Tab, Delete, стрелочки)
        if (event.ctrlKey || event.metaKey || key.length > 1) {
            return;
        }

        // Разрешаем только цифры
        if (/[0-9]/.test(key)) {
            return;
        }

        // Разрешаем разделитель дроби (точку или запятую), но строго ОДИН раз за ввод
        if (key === '.' || key === ',') {
            const currentString = event.target.value;
            if (!currentString.includes('.') && !currentString.includes(',')) {
                return;
            }
        }

        // Любые другие символы полностью отсекаем
        event.preventDefault();
    },

    // 🛑 МЕТОД ФИЛЬТРАЦИИ ВСТАВКИ: Отсекает копирование текста с буквами
    filterPaste(event) {
        const pasteData = (event.clipboardData || window.clipboardData).getData('text');

        // Очищаем пробелы и переводим запятую в точку для валидации регулярным выражением
        const cleanData = pasteData.replace(/\s+/g, '').replace(',', '.');

        // Разрешаем вставку только в том случае, если строка является валидным числом (целым или дробным)
        if (isNaN(parseFloat(cleanData)) || !/^([0-9]+(\.[0-9]+)?)$/.test(cleanData)) {
            event.preventDefault();
        }
    },

    cleanNumber(str) {
        if (typeof str !== 'string') return str;
        return parseFloat(str.replace(/\s+/g, '').replace(',', '.'));
    },

    formatNumber(num) {
        if (isNaN(num) || num === null) return '';
        if (num === 0) return '0';

        if (num % 1 !== 0) {
            let str = num.toFixed(6).replace(/\.?0+$/, '');
            let parts = str.split('.');
            parts[0] = parseInt(parts[0]).toLocaleString('ru-RU');
            return parts.join('.');
        }
        return num.toLocaleString('ru-RU');
    },

    updateFromField(rawValue, targetPrefix) {
        this.values[targetPrefix] = rawValue;

        let numericValue = this.cleanNumber(rawValue);

        if (rawValue === '' || isNaN(numericValue)) {
            this.prefixes.forEach(p => {
                if (p !== targetPrefix) this.values[p] = '';
            });
            return;
        }

        let targetIndex = this.prefixes.indexOf(targetPrefix);
        let baseValue = numericValue * Math.pow(1000, targetIndex);

        this.prefixes.forEach((prefix) => {
            if (prefix === targetPrefix) return;

            let prefixIndex = this.prefixes.indexOf(prefix);
            let convertedValue = baseValue / Math.pow(1000, prefixIndex);

            this.values[prefix] = this.formatNumber(convertedValue);
        });
    },

    getUnitLabel(prefix) {
        let currentType = this.types.find(t => t.code === this.activeType); let unitSign = currentType ? currentType.unit : 'H/s';
        if (prefix === '') return unitSign;
        let displayPrefix = prefix === 'k' ? 'k' : prefix.toUpperCase(); return displayPrefix + unitSign;
    },

    getPrefixName(prefix) {
        let names = { '': 'Базовая единица', 'k': 'Кило (Kilo)', 'M': 'Мега (Mega)', 'G': 'Гига (Giga)', 'T': 'Тера (Tera)', 'P': 'Пета (Peta)', 'E': 'Экса (Exa)', 'Z': 'Зетта (Zetta)' };
        return names[prefix] || '';
    }
});
