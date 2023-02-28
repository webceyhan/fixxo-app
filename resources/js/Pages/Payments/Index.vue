<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
                <PrimaryButton
                    label="New"
                    :href="route('payments.create')"
                    class="ml-5 mr-auto"
                />
                <Pagination v-bind="payments" />
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="payment in payments.data"
                :key="payment.id"
                :href="route('payments.show', payment.id)"
            >
                <span class="w-1/5">
                    {{ payment.type }}
                    <br />
                    {{ payment.user.name }}
                </span>
                <span class="w-2/5 text-gray-400">
                    {{ payment.asset.name }}
                    <br />
                    {{ payment.asset.customer?.name }}
                </span>
                <span class="w-fit text-gray-400"> {{ payment.amount }}€ </span>
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
