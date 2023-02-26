<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    assets: Object,
    filters: Object,
});

const { brand, type, ...restFilters } = props.filters;
</script>

<template>
    <AuthenticatedCrudLayout title="Assets">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="restFilters" />
                <Pagination v-bind="assets" />
            </div>
        </template>

        <template #sidenav>
            <h3
                class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2"
            >
                Filter by type
            </h3>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <Link
                    v-for="(value, i) in type"
                    :key="i"
                    :href="$page.url"
                    :data="{ type: value }"
                    class="text-indigo-500 hover:text-indigo-900 dark:hover:text-white"
                    preserve-state
                >
                    #{{ value }}
                </Link>
            </div>

            <h3
                class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-10 mb-2"
            >
                Filter by brand
            </h3>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <Link
                    v-for="(value, i) in brand"
                    :key="i"
                    :href="$page.url"
                    :data="{ brand: value }"
                    class="text-indigo-500 hover:text-indigo-900 dark:hover:text-white"
                    preserve-state
                >
                    #{{ value }}
                </Link>
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="asset in assets.data"
                :key="asset.id"
                :href="route('assets.show', asset.id)"
            >
                <span class="w-2/5">
                    {{ asset.brand }}
                    {{ asset.name }}
                </span>
                <span class="w-2/5 text-gray-400">
                    {{ asset.customer.name }}
                </span>
                <span class="w-fit text-gray-400">
                    tasks {{ asset.tasks_count }}
                </span>
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
