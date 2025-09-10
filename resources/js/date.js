window.dateTransform = function (el) {
    let date = new Date(Date.parse(el.getAttribute("data-date").replace(/ /g, "T")));
    if (date == 'Invalid Date') date = new Date(+el.getAttribute("data-date"));

    date = new Date(
        Date.UTC(
            date.getFullYear(),
            date.getMonth(),
            date.getDate(),
            date.getHours(),
            date.getMinutes(),
            date.getSeconds()
        )
    );

    switch (el.getAttribute("data-type")) {
        case 'datetime':
            date = date.toLocaleDateString(window.locale, {
                month: "short",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
            });
            break;
        case 'date':
            date = date.toLocaleDateString(window.locale, {
                year: "numeric",
                month: "long",
                day: "numeric",
            });
            break;
        case 'shortdate':
            date = date.toLocaleDateString(window.locale, {
                month: "short",
                day: "numeric",
            });
            break;
        case 'month':
            date = date.toLocaleDateString(window.locale, {
                year: "numeric",
                month: "long",
            });
            break;
        default:
            date = date.toLocaleDateString(window.locale, {
                month: "short",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
            });
            break;
    }

    el.textContent = date;
}