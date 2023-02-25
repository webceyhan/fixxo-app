<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    payments: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Payments">
        <Pagination v-bind="payments" />

        <br />

        <StackedList>
            <StackedListItem
                v-for="payment in payments.data"
                :key="payment.id"
                :href="route('payments.show', payment.id)"
            >
                {{ payment.type }} - {{ payment.amount }}€
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
