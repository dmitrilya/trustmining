import { Root, Tooltip, color, DataProcessor } from "@amcharts/amcharts5";
import { XYChart, DateAxis, AxisRendererX, ValueAxis, AxisRendererY, XYCursor, LineSeries } from "@amcharts/amcharts5/xy";
import am5locales_ru_RU from "@amcharts/amcharts5/locales/ru_RU";

window.buildGraph = (data, period, div, valueYField, visibleY = false) => {
    let root = Root.new(div);

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
        tapToActivate: true,
    }));

    let xAxis = chart.xAxes.push(DateAxis.new(root, {
        groupData: false,
        groupInterval: { timeUnit: "week", count: 1 },
        baseInterval: { timeUnit: "day", count: 1 },
        min: window.dateDiffs[period],
        renderer: AxisRendererX.new(root, {}),
        tooltip: Tooltip.new(root, {}),
        tooltipLocation: 0,
    }));

    let yAxis = chart.yAxes.push(ValueAxis.new(root, {
        visible: visibleY,
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
        valueYField: valueYField,
        valueXField: "date",
        locationX: 0,
        fill: color(0x404099),
        stroke: color(0x404099),
        seriesTooltipTarget: "bullet",
        tooltip: Tooltip.new(root, {
            labelText: "{valueY}"
        }),
    }));
    series.data.processor = DataProcessor.new(root, {
        emptyAs: 0
    });

    series.data.setAll(data);
    window[div + '_chart'] = chart;
}