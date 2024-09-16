import './bootstrap';
import './toast';
import './chat';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.addressSuggs = function (address, list, open) {
    if (address.length)
        return axios.get('/address/suggestions?address=' + address).then((r) => {
            if (r.data.success) {
                list.innerHTML = '';

                if (!r.data.suggestions.length) return false;

                for (suggestion of r.data.suggestions) {
                    list.insertAdjacentHTML(
                        'beforeend',
                        `<li role="option" class="cursor-default select-none" @click="$refs.search.value = $el.firstElementChild.lastElementChild.text; open = false">
                            <div class="w-full py-2 px-3 text-gray-500 group-hover:bg-gray-200">${suggestion.unrestricted_value}</div>
                        </li>`
                    );
                }

                return true;
            } else return open;
        });

    return false;
}

window.search = function (query, list, open) {
    if (query.length)
        return axios.get('/search?query=' + query).then((r) => {
            if (r.data.success) {
                list.innerHTML = '';

                if (!r.data.suggestions.length) return false;

                for (suggestion of r.data.suggestions) {
                    list.insertAdjacentHTML(
                        'beforeend',
                        `<li role="option" class="relative cursor-default select-none hover:bg-gray-200 py-2 px-3">
                            <a href="${suggestion.href}" class="flex items-center text-sm">
                                <div class="w-full text-gray-500">${suggestion.name}</div>
                                <div class="ml-auto cursor-default inline-flex items-center px-2 py-1 bg-gray-50 border border-gray-300 rounded-md text-xxs text-gray-700 uppercase shadow-sm transition ease-in-out duration-150">${suggestion.model}</div>
                            </a>
                        </li>`
                    );
                }

                return true;
            } else return open;
        });

    return false;
}

window.toggleHidden = function (adId) {
    return axios.put('/ads/' + adId + '/toggle-hidden');
}

window.scrollBottom = function (el) {
    el.scrollTo(0, el.scrollHeight);
}

window.sendReview = function (form) {
    const data = new FormData(form);

    if (!data.get('rating')) return window.pushToastAlert('Необходимо поставить оценку', 'error');

    return axios.post('/reviews/store', data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
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

    _.each(document.getElementsByClassName("date-transform"), function (el) {
        let date = new Date(Date.parse(el.getAttribute("data-date").replace(/ /g, "T")));
        date = new Date(
            Date.UTC(
                date.getFullYear(),
                date.getMonth(),
                date.getDate(),
                date.getHours(),
                date.getMinutes(),
                date.getSeconds()
            )
        );

        switch (el.getAttribute("data-type")) {
            case 'datetime':
                date = date.toLocaleDateString('ru', {
                    month: "long",
                    day: "numeric",
                    hour: "numeric",
                    minute: "numeric",
                });
                break;
            case 'date':
                date = date.toLocaleDateString('ru', {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                });
                break;
            default:
                date = date.toLocaleDateString('ru', {
                    month: "long",
                    day: "numeric",
                    hour: "numeric",
                    minute: "numeric",
                });
                break;
        }



        el.textContent = date;
    });

    return;
} 