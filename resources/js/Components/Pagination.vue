<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps([
    "from",
    "to",
    "total",
    "prev_page_url",
    "next_page_url",
]);

const hasPrev = computed(() => props.prev_page_url !== null);
const hasNext = computed(() => props.next_page_url !== null);
</script>

<template>
    <div class="flex items-center justify-end gap-4 text-sm font-semibold">
        <span class="text-gray-600 dark:text-gray-400">
            Showing {{ from }} to {{ to }} of {{ total }} Entries
        </span>

        <div class="inline-flex">
            <Link
                as="button"
                :disabled="!hasPrev"
                :href="prev_page_url ?? '#'"
                class="text-gray-800 bg-gray-300 enabled:hover:bg-gray-400 dark:bg-gray-400 dark:enabled:hover:bg-gray-300 disabled:opacity-70 py-2 px-4 rounded-l"
            >
                Prev
            </Link>

            <Link
                as="button"
                :disabled="!hasNext"
                :href="next_page_url ?? '#'"
                class="text-gray-800 bg-gray-300 enabled:hover:bg-gray-400 dark:bg-gray-400 dark:enabled:hover:bg-gray-300 disabled:opacity-70 py-2 px-4 rounded-r"
            >
                Next
            </Link>
        </div>
    </div>
</template>
