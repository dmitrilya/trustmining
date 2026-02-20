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

window.carousel = () => {
    return {
        isDown: false,
        isDraggingX: false,
        startX: 0,
        deltaX: 0,
        scrollLeft: 0,
        velocity: 0,
        lastX: 0,
        lastTime: 0,
        init() {
            const container = this.$refs.container;

            container.addEventListener(
                'touchmove',
                (e) => this.move(e),
                { passive: false }
            );
        },
        start(e) {
            this.isDown = true;

            this.startY = e.pageY || e.touches[0].pageY;
            this.isDraggingX = false;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;

            this.startX = pageX;
            this.lastX = pageX;
            this.lastTime = performance.now();

            this.scrollLeft = container.scrollLeft;

            container.classList.add('dragging');
            container.style.scrollBehavior = 'auto';
            container.style.setProperty('scroll-snap-type', 'none');
        },
        move(e) {
            if (!this.isDown) return;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;
            const pageY = e.pageY || e.touches[0].pageY;
            const now = performance.now();

            const dx = pageX - this.startX;
            const dy = pageY - (this.startY || pageY);

            // если направление ещё не определено
            if (!this.isDraggingX) {
                if (Math.abs(dx) > 5) {
                    this.isDraggingX = Math.abs(dx) > Math.abs(dy);
                }
                if (!this.isDraggingX) return;
            }

            e.preventDefault(); // блокируем ТОЛЬКО если горизонтальный свайп

            this.deltaX = dx;

            const walk = this.deltaX * 1.2;
            container.scrollLeft = this.scrollLeft - walk;

            const dt = now - this.lastTime;
            this.velocity = (pageX - this.lastX) / dt;

            this.lastX = pageX;
            this.lastTime = now;
        },
        end() {
            if (!this.isDown) return;

            const container = this.$refs.container;
            this.isDown = false;

            const card = container.firstElementChild;
            if (!card) return;

            const style = window.getComputedStyle(card);
            const marginRight = parseInt(style.marginRight) || 0;
            const cardWidth = card.offsetWidth + marginRight;

            const currentScroll = container.scrollLeft;
            let index = Math.round(currentScroll / cardWidth);

            const threshold = 0.25;     // меньше чем 1/3
            const velocityLimit = 0.5;  // скорость для "быстрого свайпа"

            const progress = (currentScroll % cardWidth) / cardWidth;

            // Быстрый свайп — всегда перелистываем
            if (Math.abs(this.velocity) > velocityLimit) {
                index += this.velocity < 0 ? 1 : -1;
            } else {
                // Медленный свайп — проверяем порог
                if (this.deltaX < 0 && progress > threshold) {
                    index += 1;
                }
                if (this.deltaX > 0 && progress < (1 - threshold)) {
                    index -= 1;
                }
            }

            const totalCards = container.children.length;
            const maxIndex = totalCards - 1;

            index = Math.max(0, Math.min(index, maxIndex));

            container.scrollTo({
                left: index * cardWidth,
                behavior: 'smooth'
            });

            setTimeout(() => {
                container.style.removeProperty('scroll-snap-type');
            }, 350);

            this.deltaX = 0;
            this.velocity = 0;
            this.isDraggingX = false;
        }
    }
}

window.toc = (article, name) => {
    const headings = article.querySelectorAll('h2, h3');
    if (headings.length === 0) return;

    const tocList = document.createElement('ul');
    tocList.classList.add('space-y-1.5');

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