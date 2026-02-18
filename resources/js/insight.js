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
        startX: 0,
        deltaX: 0,
        scrollLeft: 0,
        velocity: 0,
        lastX: 0,
        lastTime: 0,
        start(e) {
            this.isDown = true;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;

            this.startX = pageX;
            this.lastX = pageX;
            this.lastTime = performance.now();

            this.scrollLeft = container.scrollLeft;

            container.style.scrollBehavior = 'auto';
            container.style.scrollSnapType = 'none';
        },
        move(e) {
            if (!this.isDown) return;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;
            const now = performance.now();

            this.deltaX = pageX - this.startX;

            const walk = this.deltaX * 1.2;
            container.scrollLeft = this.scrollLeft - walk;

            // считаем скорость
            const dx = pageX - this.lastX;
            const dt = now - this.lastTime;

            this.velocity = dx / dt; // px per ms

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
                container.style.scrollSnapType = 'x mandatory';
            }, 350);

            this.deltaX = 0;
            this.velocity = 0;
        }
    }
}