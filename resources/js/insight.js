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
        start(e) {
            this.isDown = true;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;

            this.startX = pageX;
            this.scrollLeft = container.scrollLeft;

            container.style.scrollBehavior = 'auto';
            container.style.scrollSnapType = 'none';
        },

        move(e) {
            if (!this.isDown) return;

            const container = this.$refs.container;
            const pageX = e.pageX || e.touches[0].pageX;

            this.deltaX = pageX - this.startX;

            const walk = this.deltaX * 1.2;

            container.scrollLeft = this.scrollLeft - walk;
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

            const baseIndex = Math.floor(currentScroll / cardWidth);
            const progress = (currentScroll % cardWidth) / cardWidth;

            let index = baseIndex;

            const threshold = 0.22;

            if (this.deltaX < 0) {
                if (progress > threshold) {
                    index = baseIndex + 1;
                }
            } else if (this.deltaX > 0) {
                if (progress < (1 - threshold)) {
                    index = baseIndex;
                } else {
                    index = baseIndex + 1;
                }
            }

            const maxIndex = Math.floor(
                (container.scrollWidth - container.clientWidth) / cardWidth
            );

            index = Math.max(0, Math.min(index, maxIndex));

            const target = index * cardWidth;

            container.scrollTo({
                left: target,
                behavior: 'smooth'
            });

            setTimeout(() => {
                container.style.scrollSnapType = 'x mandatory';
            }, 350);

            this.deltaX = 0;
        }
    }
}