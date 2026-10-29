export var modelsData = () => ({
    models: [],
    sourceModels: [],
    algorithms: [],
    search: '',
    algo: null,
    sortCol: null,
    sortAsc: true,
    observer: null,
    pageCount: 10,
    page: 1,

    async init() {
        let resp = await fetch(window.location.origin + window.location.pathname + '/get-models');
        const data = await resp.json();

        this.sourceModels = Object.freeze(data.m);
        this.algorithms = Object.freeze(data.a);
        this.models = [...this.sourceModels];

        this.$nextTick(() => {
            this.setupObserver();
        });
    },

    sort(col, asc = true) {
        if (this.sortCol === col) this.sortAsc = !this.sortAsc;
        else this.sortAsc = asc;
        this.sortCol = col;
        this.models = [...this.models].sort((a, b) => {
            if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
            if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
            return 0;
        });

        this.page = 1;
        this.$nextTick(() => {
            this.setupObserver();
        });
    },

    filter(algo, search) {
        this.algo = algo;
        this.search = search.toLowerCase();
        this.models = this.sourceModels.filter(
            model => (!this.algo || this.algo && model.a == this.algo) && model.n.toLowerCase().includes(this.search)
        );

        this.page = 1;
        this.$nextTick(() => {
            this.setupObserver();
        });
    },

    setupObserver() {
        if (this.observer) this.observer.disconnect();

        const rows = Array.from(document.querySelectorAll('.model'));
        const lastRow = rows[rows.length - 1];

        if (!lastRow || this.pageCount * this.page >= this.models?.length) return;

        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.page++;
                    this.observer.unobserve(entry.target);

                    this.$nextTick(() => {
                        this.setupObserver();
                    });
                }
            });
        }, {
            root: null,
            rootMargin: '200px',
            threshold: 0.1
        });

        this.observer.observe(lastRow);
    }
});