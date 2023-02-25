<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    customers: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Customers">
        <Pagination v-bind="customers" />

        <br />

        <StackedList>
            <StackedListItem
                v-for="customer in customers.data"
                :key="customer.id"
                :href="route('customers.show', customer.id)"
            >
                {{ customer.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
