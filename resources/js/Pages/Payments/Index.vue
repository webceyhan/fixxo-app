<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    payments: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Payments">
        <StackedList>
            <StackedListItem
                v-for="payment in payments"
                :key="payment.id"
                :href="route('payments.show', payment.id)"
            >
                {{ payment.type }} - {{ payment.amount }}€
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
