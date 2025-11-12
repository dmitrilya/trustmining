import { Root, Theme, Tooltip, color, LinearGradient, RoundedRectangle, DataProcessor } from "@amcharts/amcharts5";
import { XYChart, DateAxis, AxisRendererX, ValueAxis, AxisRendererY, XYCursor, LineSeries } from "@amcharts/amcharts5/xy";
import am5locales_ru_RU from "@amcharts/amcharts5/locales/ru_RU";

window.buildGraph = (data, period, div, valueYField, visibleY = false) => {
    let isDark = document.body.classList.contains('dark');
    let root = Root.new(div);

    root.locale = am5locales_ru_RU;
    root.tapToActivate = true;

    const theme = Theme.new(root);

    theme.rule("AxisLabel").setAll({
        fill: isDark ? color(0x9ca3af) : color(0x6b7280),
        fontSize: "12px"
    });

    root.setThemes([theme]);

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

    let zoomOutButtonContainer = RoundedRectangle.new(root, {
        fillGradient: LinearGradient.new(root, {
            stops: [{
                color: color(0x7966ff),
                opacity: 0.7
            }, {
                color: color(0x404099),
                opacity: 0.7
            }],
            rotation: 360
        }),
        cursorOverStyle: 'pointer'
    });

    zoomOutButtonContainer.states.create("hover", {
        fillGradient: LinearGradient.new(root, {
            stops: [{
                color: color(0x7966ff),
                opacity: 1
            }, {
                color: color(0x404099),
                opacity: 1
            }],
            rotation: 360
        }),
    });

    chart.zoomOutButton.set("background", zoomOutButtonContainer);

    let xAxis = chart.xAxes.push(DateAxis.new(root, {
        groupData: false,
        groupInterval: { timeUnit: "week", count: 1 },
        baseInterval: { timeUnit: "day", count: 1 },
        min: window.dateDiffs[period],
        renderer: AxisRendererX.new(root, {}),
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

    let tooltip = Tooltip.new(root, {
        labelHTML: '<div class="text-gray-300 dark:text-gray-400 text-xxs sm:text-xs font-bold">{valueX.formatDate()}</div><div class="text-white dark:text-gray-200 text-sm sm:text-base">{valueY}</div>'
    });

    tooltip.get("background").setAll({
        stroke: isDark ? color(0x18181b) : color(0xffffff),
    });

    let series = chart.series.push(LineSeries.new(root, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: valueYField,
        valueXField: "date",
        locationX: 0,
        fill: color(0x7966ff),
        stroke: color(0x7966ff),
        seriesTooltipTarget: "bullet",
        tooltip: tooltip,
    }));
    series.data.processor = DataProcessor.new(root, {
        emptyAs: 0
    });

    series.data.setAll(data);
    window[div + '_chart'] = chart;
}