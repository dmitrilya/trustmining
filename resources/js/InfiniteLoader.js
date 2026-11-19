class InfiniteLoader {
    constructor(options) {
        this.container = options.container ?? document.querySelector('#infinite-loader');
        this.itemSelector = options.itemSelector ?? '.card';
        this.endpoint = options.endpoint;
        this.data = options.data ?? [];

        this.startPage = options.page;
        this.page = this.startPage == options.lastPage ? 0 : this.startPage;
        this.isLoading = false;

        this.observer = new IntersectionObserver(this.handleIntersect.bind(this), {
            rootMargin: '600px',
            threshold: 0
        });

        if (!(this.startPage == options.lastPage == 1)) this.init();
    }

    init() {
        this.observeLastItem();
    }

    handleIntersect(entries) {
        if (entries[0].isIntersecting && !this.isLoading) this.loadMore();
    }

    async loadMore() {
        this.isLoading = true;

        try {
            const response = await axios.get(this.endpoint, {
                params: { ...this.data, page: ++this.page },
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const { html, hasMore } = response.data;

            if (html && html.trim().length > 0) {
                this.container.insertAdjacentHTML('beforeend', html);

                if (this.page > this.startPage) {
                    if (hasMore) this.observeLastItem();
                    else {
                        if (this.startPage > 1) {
                            this.page = 0;
                            this.observeLastItem();
                        } else this.observer.disconnect();
                    }
                } else if (this.page + 1 < this.startPage) this.observeLastItem();
                else this.observer.disconnect();
            }
        } catch (error) {
            console.error('InfiniteScroll Error:', error);
            this.page--;
        } finally {
            this.isLoading = false;
        }
    }

    observeLastItem() {
        const items = this.container.querySelectorAll(this.itemSelector);
        const lastItem = items[items.length - 1];

        this.observer.disconnect();
        if (lastItem) this.observer.observe(lastItem);
    }
}

window.InfiniteLoader = InfiniteLoader;