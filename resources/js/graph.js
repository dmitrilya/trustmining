import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5locales_ru_RU from "@amcharts/amcharts5/locales/ru_RU";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";

window.buildGraph = (data, period) => {
    let root = am5.Root.new("graph")
    let now = Date.now();
    window.dateDiffs = {
        '3m': now - (86400000 * 90),
        '6m': now - (86400000 * 180),
        '1y': now - (86400000 * 365),
        '3y': now - (86400000 * 1095),
        'all': null
    };

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

    let xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: { timeUnit: "day", count: 1 },
        min: window.dateDiffs[period],
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {}),
        tooltipLocation: 0,
    }));
    window.xAxis = xAxis;

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