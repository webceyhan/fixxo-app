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
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <Pagination v-bind="customers" />
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="customer in customers.data"
                :key="customer.id"
                :href="route('customers.show', customer.id)"
            >
                <span class="w-1/5">{{ customer.name }}</span>
                <span class="w-2/5 text-gray-400">
                    assets {{ customer.assets_count }}
                </span>
            </StackedListItem>
        </StackedList>
    </AuthenticatedCrudLayout>
</template>
