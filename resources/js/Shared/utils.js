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
