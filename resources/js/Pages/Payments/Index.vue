<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";

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
