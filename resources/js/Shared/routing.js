import { usePage } from "@inertiajs/vue3";

/**
 * Returns reactive page url object
 *
 * TODO: improve this!
 * normally location.href is working but it's not reactive
 * so we have to use location.origin + usePage().url
 */
export const useUrl = () => new URL(location.origin + usePage().url);

/**
 * Returns reactive search params as object literal
 */
export const useSearchParams = () => Object.fromEntries(useUrl().searchParams);

/**
 * Generates links for given key and options
 * which can be used in dropdowns or navigation to filter data
 */
export const createOptionLinks = (key, options) => {
    // from ['option1', 'option2']
    // to [
    //      { label: 'option1', data:{[key]: 'option1'}, active: true },
    //      { label: 'option2', data:{[key]: 'option2'}, active: false },
    // ]

    const selectedOption = useSearchParams()[key];

    return options.map((option) => ({
        label: option,
        data: { [key]: option },
        active: option === selectedOption,
    }));
};
