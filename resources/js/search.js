export const search = () => ({
    query: '',
    suggestions: {},
    activeCategory: null,
    loading: false,
    requestId: 0,

    async search() {
        const query = this.query.trim();
        const requestId = ++this.requestId;

        if (!query || query.length < 2) {
            this.suggestions = {};
            this.activeCategory = null;
            this.loading = false;
            return;
        }

        this.loading = true;

        try {
            const response = await axios.get('/search', {
                params: { query }
            });

            if (requestId !== this.requestId) return;

            if (!response.data.success) {
                this.suggestions = {};
                this.activeCategory = null;
                return;
            }

            const suggestions = response.data.suggestions ?? {};

            this.suggestions = Object.fromEntries(
                Object.entries(suggestions).filter(([, category]) =>
                    Array.isArray(category.items) && category.items.length > 0
                )
            );

            const categories = Object.keys(this.suggestions);

            this.activeCategory = categories.includes(this.activeCategory)
                ? this.activeCategory
                : categories[0] ?? null;

        } catch (error) {
            if (requestId === this.requestId) {
                this.suggestions = {};
                this.activeCategory = null;
            }

            console.error('Search request failed:', error);
        } finally {
            if (requestId === this.requestId) this.loading = false;
        }
    },

    clear() {
        this.query = '';
        this.suggestions = {};
        this.activeCategory = null;
        this.loading = false;

        this.requestId++;
    },

    get categories() {
        return Object.keys(this.suggestions);
    },

    get activeItems() {
        return this.activeCategory
            ? this.suggestions[this.activeCategory]?.items ?? []
            : [];
    }
});