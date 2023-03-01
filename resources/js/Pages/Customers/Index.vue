<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CustomerList from "./Partials/CustomerList.vue";

defineProps({
    customers: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Customers">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <PrimaryButton
                    label="New"
                    :href="route('customers.create')"
                    class="ml-5 mr-auto"
                />
                <Pagination v-bind="customers" />
            </div>
        </template>

        <CustomerList :customers="customers.data" />
    </AuthenticatedCrudLayout>
</template>
