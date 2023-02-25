<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    assets: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Assets">
        
        <Pagination v-bind="assets" />

        <br />

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
