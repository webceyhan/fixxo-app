import { useSearchParams } from "./routing";

/**
 * Normalize array-like keys to object
 */
const normalizeParam = (key, value) => {
    // try to unwrap array-like keys
    const [, group, name] = key.match(/(^.*)\[(.*)\]/) ?? [];

    // convert {filter[key]:value} to filter:{key:value}
    return group ? { [group]: { [name]: value } } : { [key]: value };
};

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
        data: normalizeParam(key, value),
        active: value === selectedOption,
        icon: withIcons ? value : null,
    }));
}
