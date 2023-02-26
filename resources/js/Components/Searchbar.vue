<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
// import { debounce } from "lodash";

defineProps({
    filters: Object,
});

const onSearch = ({ target }) => {
    // debounce(() => {
    router.get(
        usePage().url,
        { search: target.value },
        { preserveState: true }
    );
    // }, 500)();
};

const onFilter = ({ target }) => {
    router.get(
        usePage().url,
        { [target.name]: target.value },
        { preserveState: true }
    );
};

// get search params from url
const searchParams = computed(() => {
    // todo: improve this code!
    // usePage is reactive, so we can use it to get the current page params
    // when combined with preserve-state link option
    // location.origin : http://hascom-rma.test'
    // usePage().url:   /customers?status=inactive&key=ca
    const url = location.origin + usePage().url;
    const { searchParams } = new URL(url);

    return [...searchParams.keys()].reduce((acc, key) => {
        acc[key] = searchParams.get(key);
        return acc;
    }, {});
});

// reset search params
const onReset = () => {
    router.get(location.pathname, {}, { preserveState: true });
};

// is dirty
const isDirty = computed(() => {
    return Object.keys(searchParams.value).length > 0;
});
</script>

<template>
    <div class="flex flex-col sm:flex-row items-center">

        <div class="block relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2"
                ><svg
                    viewBox="0 0 24 24"
                    class="h-4 w-4 fill-current text-gray-500"
                >
                    <path
                        d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"
                    ></path></svg
            ></span>

            <input
                placeholder="Search"
                type="search"
                :value="searchParams.search"
                class="appearance-none rounded-l border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
                @input="onSearch"
            />
        </div>

        <select
            v-for="(options, key) in filters"
            :key="key"
            :name="key"
            :value="searchParams[key]"
            @change="onFilter"
            class="appearance-none h-full block border-x-0 border-r last:rounded-r  bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500"
        >
            <option value="">{{ key }}</option>
            <option v-for="option in options" :key="option" :value="option">
                {{ option }}
            </option>
        </select>



        <button
            v-if="isDirty"
            @click="onReset"
            class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            Reset
        </button>
    </div>
</template>
