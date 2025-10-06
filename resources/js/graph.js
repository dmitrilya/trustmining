import { Root, Tooltip, color } from "@amcharts/amcharts5";
import { XYChart, DateAxis, AxisRendererX, ValueAxis, AxisRendererY, XYCursor, LineSeries } from "@amcharts/amcharts5/xy";
import am5locales_ru_RU from "@amcharts/amcharts5/locales/ru_RU";

window.buildGraph = (data, period) => {
    let root = Root.new("graph")
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

    let chart = root.container.children.push(XYChart.new(root, {
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

    let xAxis = chart.xAxes.push(DateAxis.new(root, {
        baseInterval: { timeUnit: "day", count: 1 },
        min: window.dateDiffs[period],
        renderer: AxisRendererX.new(root, {}),
        tooltip: Tooltip.new(root, {}),
        tooltipLocation: 0,
    }));
    window.xAxis = xAxis;

    let yAxis = chart.yAxes.push(ValueAxis.new(root, {
        visible: false,
        renderer: AxisRendererY.new(root, {})
    }));

    let cursor = chart.set("cursor", XYCursor.new(root, {
        behavior: "none",
        xAxis: xAxis
    }));
    cursor.lineY.set("visible", false);

    let series = chart.series.push(LineSeries.new(root, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
        locationX: 0,
        fill: color(0x404099),
        stroke: color(0x404099),
        seriesTooltipTarget: "bullet",
        tooltip: Tooltip.new(root, {
            labelText: "{valueY}"
        })
    }));

    series.data.setAll(data);
}