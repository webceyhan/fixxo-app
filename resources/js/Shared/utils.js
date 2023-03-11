export function delay(ms, fn = () => {}) {
    return new Promise(() => setTimeout(fn, ms));
}

export function debounce(fn, wait) {
    let timer;

    return function (...args) {
        // clear any pre-existing timer
        timer && clearTimeout(timer);

        // get the current context
        const context = this;

        // call the function if time expires
        timer = setTimeout(() => fn.apply(context, args), wait);
    };
}

export function throttle(fn, wait) {
    let throttled = false;

    return function (...args) {
        if (!throttled) {
            fn.apply(this, args);

            throttled = true;

            setTimeout(() => (throttled = false), wait);
        }
    };
}

// FORMATTERS //////////////////////////////////////////////////////////////////////////////////////

export function formatNumber(value) {
    return new Intl.NumberFormat("en-BE", {
        style: "decimal",
    }).format(value);
}

export function formatMoney(value) {
    return new Intl.NumberFormat("en-BE", {
        style: "currency",
        currency: "EUR",
    }).format(value);
}

export function formatDate(date, short = true) {
    // skip if empty or null
    if (!date || date == "") return "";

    return Intl.DateTimeFormat("en-BE", {
        year: short ? "2-digit" : "numeric",
        month: short ? "2-digit" : "long",
        day: "2-digit",
    }).format(new Date(date));
}

export function formatPhone(value, defaultCountryCode = "32") {
    // skip if empty or null
    if (!value || value == "") return "";

    // remove all non numeric characters
    value = `${value}`.replace(/\D/g, "");

    // remove leading 00
    value = value.replace(/^00/, "");

    // normalize leading 0
    value = value.replace(/^0/, defaultCountryCode);

    return `+${value}`;
}
