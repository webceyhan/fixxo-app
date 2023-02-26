<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";

defineProps({
    customers: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Customers">
        <div class="flex justify-between items-center">
            <Searchbar :filters="filters" />
            <Pagination v-bind="customers" />
        </div>

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
