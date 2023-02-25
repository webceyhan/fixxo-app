<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";

defineProps({
    asset: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="asset.name">
        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in asset"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
