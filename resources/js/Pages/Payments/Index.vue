<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
    <AuthenticatedLayout title="Payments">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <Pagination v-bind="payments" />
            </div>
        </template>

        <Card flush>
            <PaymentList :payments="payments.data" />
        </Card>
    </AuthenticatedLayout>
</template>
