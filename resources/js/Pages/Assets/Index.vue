<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import AssetList from "./Partials/AssetList.vue";
import Card from "@/Components/Card.vue";

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

        <div class="flex gap-6">
            <div class="hidden lg:block w-1/6 flex-shrink-0">
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
            </div>

            <div class="flex-1">
                <Card>
                    <AssetList :assets="assets.data" />
                </Card>
            </div>
        </div>
    </AuthenticatedCrudLayout>
</template>
