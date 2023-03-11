import { useSearchParams } from "./routing";

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

// OPTIONS /////////////////////////////////////////////////////////////////////////////////////////

/**
 * Normalize array-like options to array of objects
 *
 * possible input:
 * - {
 *      pending: 'Pending',
 *      in_progress: 'In progress',
 *    }
 *
 * - ['pending', 'in_progress']
 *
 * - [
 *      {value: 'pending', label: 'Pending'}
 *      {value: 'in_progress', label: 'In progress'}
 *    ]
 */
export function normalizeOptions(options, fn = () => ({})) {
    // check if object literal was passed
    if (!Array.isArray(options)) {
        // convert {key: 'value'} to [{value: 'key', label: 'value'}]
        return Object.entries(options).map(([value, label]) => ({
            value,
            label,
            ...fn(value), // extra data
        }));
    }

    // normalize array of strings to array of objects
    return options.map((option) => {
        // check if object literal was passed
        if (typeof option === "object") {
            return { ...option, ...fn(option.value) };
        }

        // convert string to object literal
        return {
            value: option,
            label: option,
            ...fn(option), // extra data
        };
    });
}

/**
 * Generates links for given key and options
 * which can be used in dropdowns or navigation to filter data
 */
export function createOptionLinks(key, options, withIcons = false) {
    // from ['option1', 'option2']
    // to [
    //      { label: 'option1', data:{[key]: 'option1'}, active: true },
    //      { label: 'option2', data:{[key]: 'option2'}, active: false },
    // ]

    const selectedOption = useSearchParams()[key];

    return normalizeOptions(options, (value) => ({
        data: { [key]: value },
        active: value === selectedOption,
        icon: withIcons ? value : null,
    }));
}
