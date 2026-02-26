window.channelToggleSubscription = (el, route) => {
    el.disabled = true;

    axios.post(route).then(r => {
        if (!r.data.success) pushToastAlert(r.data.error, 'error');
        else {
            el.innerText = r.data.text;
            el.disabled = false;
        }
    })
}

window.addComment = async (form, text, parentId) => {
    if (!text) return;

    const container = document.getElementById('comments-container');

    axios.post(form.action, { text: text, last_id: container.dataset.lastId, parent_id: parentId }).then(r => {
        if (parentId && r.data.html_reply) {
            const repliesContainer = document.querySelector(`[data-comment_id="${parentId}"] .replies-container`);
            if (repliesContainer) {
                repliesContainer.insertAdjacentHTML('afterbegin', r.data.html_reply);

                //window.Alpine.initTree(repliesContainer.firstElementChild);
            }
        }

        if (r.data.last_id && r.data.html_comments) {
            container.insertAdjacentHTML('afterbegin', r.data.html_comments);

            container.dataset.lastId = r.data.last_id;
        }
    });
}

window.toc = (article, name) => {
    const headings = article.querySelectorAll('h2, h3');
    if (headings.length === 0) return;

    const tocList = document.createElement('ul');
    tocList.classList.add('space-y-2');

    headings.forEach((heading, index) => {
        const id = `toc-anchor-${index}`;
        heading.id = id;

        const listItem = document.createElement('li');
        const link = document.createElement('a');

        link.textContent = heading.textContent;
        link.href = `#${id}`;

        if (heading.tagName.toLowerCase() === 'h3') {
            listItem.classList.add('ml-2', 'list-none', 'text-gray-600', 'dark:text-gray-400', 'group-hover:text-gray-900', 'dark:group-hover:text-gray-100', 'marker:text-[1px]', 'text-xs', 'group', 'cursor-pointer', 'relative', 'pl-2', 'before:content-[""]', 'before:absolute', 'before:left-0', 'before:top-2', 'before:h-0.5', 'before:w-0.5', 'before:bg-current', 'before:rounded-full');
        } else {
            listItem.classList.add('list-none', 'text-xs', 'group', 'cursor-pointer');
        }

        link.classList.add('text-gray-600', 'dark:text-gray-400', 'group-hover:text-gray-900', 'dark:group-hover:text-gray-100');

        link.addEventListener('click', (e) => {
            e.preventDefault();
            heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
            history.pushState(null, null, `#${heading.innerText}`);
        });

        listItem.appendChild(link);
        tocList.appendChild(listItem);
    });

    const tocLgContainer = document.getElementById('toc-lg-container');
    const tocContainer = document.getElementById('toc-container');
    tocLgContainer.classList.add('p-4', 'bg-white/60', 'dark:bg-zinc-900/60', 'border', 'border-gray-300', 'dark:border-zinc-700', 'shadow-sm', 'shadow-logo-color', 'rounded-xl')

    const blockName = document.createElement('p');
    blockName.textContent = name;
    blockName.classList.add('mb-4', 'text-base', 'text-gray-700', 'dark:text-gray-300', 'font-bold');

    tocLgContainer.appendChild(blockName);
    tocLgContainer.appendChild(tocList);

    const tocListMobile = tocList.cloneNode(true);

    const blockNameMobile = blockName.cloneNode(true);

    tocListMobile.querySelectorAll('a').forEach((link, index) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            headings[index].scrollIntoView({ behavior: 'smooth', block: 'start' });
            history.pushState(null, null, `#${headings[index].innerText}`);
        });
    });

    if (headings.length > 3) {
        tocListMobile.classList.add('overflow-hidden', 'transition-all')
        tocListMobile.style.height = '60px';

        const btn = document.createElement('button');
        btn.textContent = 'Развернуть';
        btn.classList.add('text-sm', 'mt-2', 'text-gray-700', 'dark:text-gray-300', 'hover:text-gray-900', 'dark:hover:text-gray-100');

        let isCollapsed = true;

        btn.onclick = () => {
            if (isCollapsed) {
                tocListMobile.style.height = tocListMobile.scrollHeight + 'px';
                btn.textContent = 'Свернуть';
                isCollapsed = false;
            } else {
                tocListMobile.style.height = '60px';
                btn.textContent = 'Развернуть';
                isCollapsed = true;
            }
        };

        tocContainer.appendChild(blockNameMobile);
        tocContainer.appendChild(tocListMobile);
        tocContainer.appendChild(btn);
    } else {
        tocContainer.appendChild(blockNameMobile);
        tocContainer.appendChild(tocListMobile);
    }
}