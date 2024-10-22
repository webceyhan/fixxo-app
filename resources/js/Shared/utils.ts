type Callback = (...args: any[]) => any;

export function delay(ms: number, fn = () => {}) {
    return new Promise(() => setTimeout(fn, ms));
}

export function debounce(fn: Callback, wait: number) {
    let timer: number;

    return function (this: any, ...args: any[]) {
        // clear any pre-existing timer
        timer && clearTimeout(timer);

        // call the function if time expires
        timer = setTimeout(() => fn.apply(this, args), wait);
    };
}

export function throttle(fn: Callback, wait: number) {
    let throttled = false;

    return function (this: any, ...args: any[]) {
        if (!throttled) {
            fn.apply(this, args);

            throttled = true;

            setTimeout(() => (throttled = false), wait);
        }
    };
}

// FORMATTERS //////////////////////////////////////////////////////////////////////////////////////

export function formatNumber(value: number) {
    return new Intl.NumberFormat("en-BE", {
        style: "decimal",
    }).format(value);
}

export function formatMoney(value: number) {
    return new Intl.NumberFormat("en-BE", {
        style: "currency",
        currency: "EUR",
        notation: "compact",
        compactDisplay: "short",
    }).format(value);
}

// export function formatDate(date, long = false) {
//     // skip if empty or null
//     if (!date || date == "") return "";

//     return Intl.DateTimeFormat("en-BE", {
//         year: long ? "numeric" : "2-digit",
//         month: long ? "long" : "2-digit",
//         day: "2-digit",
//         hour: long ? "2-digit" : undefined,
//         minute: long ? "2-digit" : undefined,
//         second: long ? "2-digit" : undefined,
//     }).format(new Date(date));
// }

const rtf = new Intl.RelativeTimeFormat("en", { style: "short" });

export function isPastDate(value?: string) {
    // skip if empty or null
    if (!value || value == "") return false;

    return new Date(value) < new Date();
}

export const formatDate = (value?: string, long = false) => {
    // skip if empty or null
    if (!value || value == "") return "";

    const date = new Date(value);

    const config: Intl.DateTimeFormatOptions = {
        // year: "2-digit",
        // month: "2-digit",
        // day: "2-digit",

        year: long ? "numeric" : "2-digit",
        month: long ? "long" : "2-digit",
        day: "2-digit",
        hour: long ? "2-digit" : undefined,
        minute: long ? "2-digit" : undefined,
        second: long ? "2-digit" : undefined,
    };

    return Intl.DateTimeFormat("en-BE", config).format(date);
};

export const formatDatetime = (timestamp?: string, long = false) => {
    // skip if empty or null
    if (!timestamp || timestamp == "") return "";

    const date = new Date(timestamp);

    const diff = Math.floor((Date.now() - date.getTime()) / 1000);
    if (diff < 60) return rtf.format(-diff, "second");
    if (diff < 3600) return rtf.format(-Math.floor(diff / 60), "minute");
    if (diff < 86400) return rtf.format(-Math.floor(diff / 3600), "hour");
    if (diff < 604800) return rtf.format(-Math.floor(diff / 86400), "day");

    const config: Intl.DateTimeFormatOptions = {
        // year: "2-digit",
        // month: "2-digit",
        // day: "2-digit",

        year: long ? "numeric" : "2-digit",
        month: long ? "long" : "2-digit",
        day: "2-digit",
        hour: long ? "2-digit" : undefined,
        minute: long ? "2-digit" : undefined,
        second: long ? "2-digit" : undefined,
    };

    // is timestamp given?
    if (timestamp?.length > 10) {
        config.hour = "2-digit";
        config.minute = "2-digit";
    }

    return Intl.DateTimeFormat("en-BE", config).format(date);
};

export const mysqlToDate = (timestamp?: string) => {
    // Convert the MySQL datetime to a suitable format for date input
    // Example MySQL datetime in ISO 8601 format: "2024-10-02T21:57:00.000000Z";
    if (!timestamp || timestamp == "") return "";

    // Create a new Date object from the MySQL datetime string
    const date = new Date(timestamp);

    // Get the date part in the correct format (YYYY-MM-DD)
    return date.toISOString().slice(0, 10);
};

export const mysqlToDatetimeLocal = (timestamp?: string) => {
    // Convert the MySQL datetime to a suitable format for datetime-local input
    // Example MySQL datetime in ISO 8601 format: "2024-10-02T21:57:00.000000Z";
    if (!timestamp || timestamp == "") return "";

    // Create a new Date object from the MySQL datetime string
    const date = new Date(timestamp);

    // Get the date and time parts in the correct format (YYYY-MM-DDTHH:MM)
    return date.toISOString().slice(0, 16);
};

export function formatPhone(value?: string, defaultCountryCode = "32") {
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
