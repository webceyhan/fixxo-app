<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    customers: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Customers">
        <StackedList>
            <StackedListItem
                v-for="customer in customers"
                :key="customer.id"
                :href="route('customers.show', customer.id)"
            >
                {{ customer.name }}
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
