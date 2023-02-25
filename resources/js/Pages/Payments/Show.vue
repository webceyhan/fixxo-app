<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";

defineProps({
    payment: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="payment.type">
        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in payment"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
