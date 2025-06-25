window.dadataSuggs = function (address, list, open, method) {
    if (!address.length || !['address', 'city'].includes(method)) return false;

    return axios.get('/dadata/suggestions/' + method + '?address=' + address).then((r) => {
        if (!r.data.success) return open;

        list.innerHTML = '';

        if (!r.data.suggestions.length) return false;

        for (let suggestion of r.data.suggestions) {
            list.insertAdjacentHTML(
                'beforeend',
                `<li role="option" class="cursor-default select-none" @click="$refs.search.value = $el.firstElementChild.textContent; open = false">
                    <div class="w-full py-2 px-3 text-gray-500 hover:bg-gray-200">${suggestion}</div>
                </li>`
            );
        }

        return true;
    });
}

window.search = function (query, list, open) {
    if (query.length)
        return axios.get('/search?query=' + query).then((r) => {
            if (r.data.success) {
                list.innerHTML = '';

                if (!r.data.suggestions.length) return false;

                for (let suggestion of r.data.suggestions) {
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