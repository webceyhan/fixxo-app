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
