<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    assets: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Assets">
        <StackedList>
            <StackedListItem
                v-for="asset in assets"
                :key="asset.id"
                :href="route('assets.show', asset.id)"
            >
                {{ asset.brand }}
                {{ asset.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
