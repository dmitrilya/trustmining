var groupBy = function (arr, key) {
    return arr.reduce(function (rv, x) {
        (rv[x[key]] ??= []).push(x);
        return rv;
    }, {});
};

export var adsStatistics = () => ({
    originalAds: [],
    ads: [],
    period: '1w',
    metric: 'views',
    sortCol: null,
    sortAsc: true,
    all_views_count: 0,
    all_views_count_before: 0,
    views_count_coef: '∞',
    all_visits_count: 0,
    all_visits_count_before: 0,
    visits_count_coef: '∞',
    all_phone_views_count: 0,
    all_phone_views_count_before: 0,
    phone_views_count_coef: '∞',
    all_tracks_count: 0,
    all_tracks_count_before: 0,
    tracks_count_coef: '∞',
    all_chats_count: 0,
    all_chats_count_before: 0,
    chats_count_coef: '∞',
    all_cr: '-',
    all_cr_before: '-',
    cr_coef: '∞',
    graph_data: [],
    async init() {
        let resp = axios.get(window.location.origin + window.location.pathname + '/get-ads-statistics').then(r => {
            this.originalAds = r.data.ads;
            this.graph_data = r.data.graph_data;
            this.ads = this.originalAds;
            if (this.ads.length) {
                this.filterViews();
                this.buildGraphs();
            }
        });

    },
    sort(col, asc = true, withoutChangeAsc = false) {
        if (!withoutChangeAsc && this.sortCol === col) this.sortAsc = !this.sortAsc;
        else this.sortAsc = asc;
        this.sortCol = col;
        this.ads.sort((a, b) => {
            if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
            if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
            return 0;
        });
    },
    changePeriod(period) {
        this.period = period;
        this.filterViews();
        window['summary_chart'].xAxes.values[0].set('min', window.dateDiffs[period]);
    },
    changeMetric(metric) {
        this.metric = metric;
        window['summary_chart'].series.values[0].set('valueYField', metric);
        window['summary_chart'].series.values[0].data.setAll(this.graph_data);
    },
    filterViews() {
        let ads = this.originalAds.map(ad => {
            ad.views_count = ad.views.filter(view => new Date(view.created_at) > window.dateDiffs[this.period]).reduce((sum, view) => sum + view.count, 0);
            ad.views_count_before = ad.views.filter(view => new Date(view.created_at) <= window.dateDiffs[this.period] && new Date(view.created_at) > window.dateDiffs[this.period + 'before']).reduce((sum, view) => sum + view.count, 0);

            ad.visits_count = ad.views.filter(view => new Date(view.created_at) > window.dateDiffs[this.period]).length;
            ad.visits_count_before = ad.views.filter(view => new Date(view.created_at) <= window.dateDiffs[this.period] && new Date(view.created_at) > window.dateDiffs[this.period + 'before']).length;

            ad.phone_views_count = Object.keys(groupBy(ad.phone_views.filter(view => new Date(view.created_at) > window.dateDiffs[this.period]), 'viewer')).length;
            ad.phone_views_count_before = Object.keys(groupBy(ad.phone_views.filter(view => new Date(view.created_at) <= window.dateDiffs[this.period] && new Date(view.created_at) > window.dateDiffs[this.period + 'before']), 'viewer')).length;

            ad.tracks_count = ad.tracks.filter(track => new Date(track.created_at) > window.dateDiffs[this.period]).length;
            ad.tracks_count_before = ad.tracks.filter(track => new Date(track.created_at) <= window.dateDiffs[this.period] && new Date(track.created_at) > window.dateDiffs[this.period + 'before']).length;

            ad.chats_count = ad.chats.filter(chat => new Date(chat.created_at) > window.dateDiffs[this.period]).length;
            ad.chats_count_before = ad.chats.filter(chat => new Date(chat.created_at) <= window.dateDiffs[this.period] && new Date(chat.created_at) > window.dateDiffs[this.period + 'before']).length;

            ad.cr = ad.visits_count > 0 ? Math.round((ad.phone_views_count + ad.tracks_count + ad.chats_count) / ad.visits_count * 10000) / 100 : '-';
            ad.cr_before = ad.visits_count_before > 0 ? Math.round((ad.phone_views_count_before + ad.tracks_count_before + ad.chats_count_before) / ad.visits_count_before * 10000) / 100 : '-';

            return ad;
        });

        this.all_views_count = ads.reduce((sum, ad) => sum + ad.views_count, 0);
        this.all_views_count_before = ads.reduce((sum, ad) => sum + ad.views_count_before, 0);
        this.views_count_coef = !this.all_views_count_before ? this.all_views_count ? '∞' : 0 : Math.round((this.all_views_count / this.all_views_count_before - 1) * 10000) / 100;

        this.all_visits_count = ads.reduce((sum, ad) => sum + ad.visits_count, 0);
        this.all_visits_count_before = ads.reduce((sum, ad) => sum + ad.visits_count_before, 0);
        this.visits_count_coef = !this.all_visits_count_before ? this.all_visits_count ? '∞' : 0 : Math.round((this.all_visits_count / this.all_visits_count_before - 1) * 10000) / 100;

        this.all_phone_views_count = ads.reduce((sum, ad) => sum + ad.phone_views_count, 0);
        this.all_phone_views_count_before = ads.reduce((sum, ad) => sum + ad.phone_views_count_before, 0);
        this.phone_views_count_coef = !this.all_phone_views_count_before ? this.all_phone_views_count ? '∞' : 0 : Math.round((this.all_phone_views_count / this.all_phone_views_count_before - 1) * 10000) / 100;

        this.all_tracks_count = ads.reduce((sum, ad) => sum + ad.tracks_count, 0);
        this.all_tracks_count_before = ads.reduce((sum, ad) => sum + ad.tracks_count_before, 0);
        this.tracks_count_coef = !this.all_tracks_count_before ? this.all_tracks_count ? '∞' : 0 : Math.round((this.all_tracks_count / this.all_tracks_count_before - 1) * 10000) / 100;

        this.all_chats_count = ads.reduce((sum, ad) => sum + ad.chats_count, 0);
        this.all_chats_count_before = ads.reduce((sum, ad) => sum + ad.chats_count_before, 0);
        this.chats_count_coef = !this.all_chats_count_before ? this.all_chats_count ? '∞' : 0 : Math.round((this.all_chats_count / this.all_chats_count_before - 1) * 10000) / 100;

        this.all_cr = this.all_visits_count ? Math.round((this.all_phone_views_count + this.all_tracks_count + this.all_chats_count) / this.all_visits_count * 10000) / 100 : 0;
        this.all_cr_before = this.all_visits_count_before ? Math.round((this.all_phone_views_count_before + this.all_tracks_count_before + this.all_chats_count_before) / this.all_visits_count_before * 10000) / 100 : 0;
        this.cr_coef = !this.all_cr_before ? this.all_cr ? '∞' : 0 : Math.round((this.all_cr / this.all_cr_before - 1) * 10000) / 100;

        this.sort(this.sortCol, this.sortAsc, true);

        this.ads = ads;
    },
    buildGraphs() {
        let graphData = [], date = this.graph_data[0].date, i = 0;
        do {
            if (this.graph_data[i]['date'] == date) {
                graphData.push(this.graph_data[i]);
                i++;
            } else graphData.push({
                date: date,
                views: 0,
                visits: 0,
                phone_views: 0,
                tracks: 0,
                chats: 0,
            });

            date += 86400000;
        } while (date <= this.graph_data[this.graph_data.length - 1].date);
        this.graph_data = graphData;

        window.buildGraph(this.graph_data, this.period, 'summary', this.metric, true);
    }
});