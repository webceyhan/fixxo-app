<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaymentList from "./Partials/PaymentList.vue";

defineProps({
    payments: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Payments">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <Pagination v-bind="payments" />
            </div>
        </template>

        <PaymentList :payments="payments.data" />
    </AuthenticatedCrudLayout>
</template>
