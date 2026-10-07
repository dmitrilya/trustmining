import { calculatorAlpine } from './calculatorAlpine';
import Alpine from 'alpinejs';
window.Alpine = Alpine;

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

window.calculateProfitCAGR = (dailyProfit, days, percent) => {
    if (percent == 0) return dailyProfit * days;

    let coef = 1 / Math.pow(1 + (percent / 100), 1 / 365);

    return dailyProfit * (1 - Math.pow(coef, days)) / (1 - coef);
}

document.addEventListener('alpine:init', () => {
    Alpine.data('calculator', calculatorAlpine);
});

document.addEventListener('alpine:initialized', () => {
    const sendHeight = () => {
        const height = document.body.scrollHeight;
        window.parent.postMessage({
            type: 'resize-calculator',
            height: height
        }, '*');
    };

    const observer = new MutationObserver(() => {
        sendHeight();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true
    });

    sendHeight();

    window.addEventListener('resize', sendHeight);
});

window.pluralize = function (count, trans) {
    let n = Math.abs(count) % 100;
    let n1 = n % 10;
    if (n > 10 && n < 20) return trans[2];
    if (n1 > 1 && n1 < 5) return trans[1];
    if (n1 === 1) return trans[0];
    return trans[2];
}

Alpine.start();