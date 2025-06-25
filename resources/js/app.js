import './bootstrap';
import './date';
import './toast';
import './chat';
import './suggestions';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.toggleHidden = function (adId) {
    return axios.put('/ad/' + adId + '/toggle-hidden').then(r => {
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

window.sendReview = function (form) {
    const data = new FormData(form);

    if (!data.get('rating')) return window.pushToastAlert('Необходимо поставить оценку', 'error');

    axios.post('/review/store', data, {
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

    if (userId) {
        userId = userId.getAttribute('content');

        Echo.private(`notifications.${userId}`).listen(".notification", e => {
            console.log('here');
        });
    }

    _.each(document.getElementsByClassName("date-transform"), window.dateTransform);

    return;
}