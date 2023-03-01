<script setup>
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    customers: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="customer in customers"
            :key="customer.id"
            :href="route('customers.show', customer.id)"
        >
            <span class="w-1/5">
                {{ customer.name }}
            </span>

            <span class="w-2/5 text-gray-400">
                assets {{ customer.assets_count }}
            </span>
        </StackedListItem>
    </StackedList>
</template>
