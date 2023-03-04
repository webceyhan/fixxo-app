<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    label: String,
});

const classes = computed(() => ({
    // base styles
    "inline-flex items-center px-4 py-2 border rounded-md shadow-sm font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150": true,
}));
</script>

<template>
    <Link v-if="$attrs.href" :class="classes" as="button">
        <slot> {{ label }} </slot>
    </Link>

    <button v-else :class="classes" type="button">
        <slot> {{ label }} </slot>
    </button>
</template>
