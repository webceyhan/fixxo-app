<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaymentList from "./Partials/PaymentList.vue";
import Card from "@/Components/Card.vue";

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

        <Card>
            <PaymentList :payments="payments.data" />
        </Card>
    </AuthenticatedCrudLayout>
</template>
