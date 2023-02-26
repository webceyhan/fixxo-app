<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";

defineProps({
    assets: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Assets">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <Pagination v-bind="assets" />
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="asset in assets.data"
                :key="asset.id"
                :href="route('assets.show', asset.id)"
            >
                {{ asset.brand }}
                {{ asset.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
