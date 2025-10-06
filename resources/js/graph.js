import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5locales_ru_RU from "@amcharts/amcharts5/locales/ru_RU";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";

window.buildGraph = (data, period) => {
    window.graph_data = data;
    if (window.root) window.root.dispose();

    let root = am5.Root.new("graph")
    window.root = root;

    if (period != 'all') {
        let dateDiffs = {
            '3m': (86400000 * 90),
            '6m': (86400000 * 180),
            '1y': (86400000 * 360),
            '3y': (86400000 * 1080),
        };
        data = data.filter(datum => datum.date > (Date.now() - dateDiffs[period]));
    }

    root.locale = am5locales_ru_RU;
    root.tapToActivate = true;

    let chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true,
        paddingRight: 0,
        paddingTop: 0,
        paddingBottom: 36,
        paddingLeft: 0,
        tapToActivate: true
    }));

    let xAxis = chart.xAxes.push(am5xy.GaplessDateAxis.new(root, {
        baseInterval: { timeUnit: "day", count: 1 },
        renderer: am5xy.AxisRendererX.new(root, {
            minGridDistance: 60,
            minorGridEnabled: true,
        }),
        tooltip: am5.Tooltip.new(root, {}),
        tooltipLocation: 0,
    }));

    let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        visible: false,
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
        behavior: "none",
        xAxis: xAxis
    }));
    cursor.lineY.set("visible", false);

    let series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
        locationX: 0,
        fill: am5.color(0x404099),
        stroke: am5.color(0x404099),
        seriesTooltipTarget: "bullet",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
        })
    }));

    series.data.setAll(data);
}