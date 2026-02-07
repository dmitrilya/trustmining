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
                    <div class="w-full py-2 px-3 text-gray-600 hover:bg-gray-200 dark:hover:text-gray-800">${suggestion}</div>
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
                        `<li role="option" class="relative select-none hover:bg-gray-100 dark:hover:bg-zinc-800">
                            <a href="${suggestion.href}" class="flex items-center text-sm py-2 px-3">
                                <div class="w-full text-gray-600">${suggestion.name}</div>
                                <div class="ml-auto inline-flex items-center px-2 py-1 bg-gray-50 dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-md text-xxs text-gray-800 dark:text-gray-300 uppercase shadow-sm shadow-logo-color transition ease-in-out duration-150">${suggestion.model}</div>
                            </a>
                        </li>`
                    );
                }

                return true;
            } else return open;
        });

    return false;
}