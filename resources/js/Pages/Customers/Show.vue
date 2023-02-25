<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";

defineProps({
    customer: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="customer.name">
        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in customer"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
