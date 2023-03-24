import { ref } from "vue";

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

export function formatDate(date, long = false) {
    // skip if empty or null
    if (!date || date == "") return "";

    return Intl.DateTimeFormat("en-BE", {
        year: long ? "numeric" : "2-digit",
        month: long ? "long" : "2-digit",
        day: "2-digit",
        hour: long ? "2-digit" : undefined,
        minute: long ? "2-digit" : undefined,
        second: long ? "2-digit" : undefined,
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

// MISC ////////////////////////////////////////////////////////////////////////////////////////////

export function useDarkTheme() {
    // read storage and OS preference
    const storedTheme = localStorage.theme;
    const isPrefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    // determine the initial value
    const isDark = ref(
        storedTheme === "dark" || (!storedTheme && isPrefersDark)
    );

    // set dark mode
    const setDark = (value) => {
        // set the value
        isDark.value = value;

        // save the value in local storage
        localStorage.theme = value ? "dark" : "light";

        // set the class on the html element
        if (value) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    };

    // toggle the value
    const toggleDark = () => setDark(!isDark.value);

    // initialize the value
    setDark(isDark.value);

    return { isDark, setDark, toggleDark };
}
