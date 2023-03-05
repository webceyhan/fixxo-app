<script setup>
import Badge from "@/Components/Badge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

defineProps({
    customers: Array,
    compact: Boolean,
});

const statusColorMap = {
    active: "primary",
    inactive: "secondary",
};
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="customer in customers"
            :key="customer.id"
            :href="route('customers.show', customer.id)"
        >
            <div class="w-full md:w-5/12">
                {{ customer.name }}

                <div v-if="customer.email" 
                
                class="hidden md:block text-sm text-gray-400 mt-1">
                    {{ customer.email }}
                </div>
            </div>

            <div
                v-if="customer.phone"
                class="hidden md:block w-3/12 text-gray-400"
            >
                {{ customer.phone }}
            </div>

            <div
                v-if="!compact && customer.assets_count"
                class="hidden md:block w-2/12 text-gray-400"
            >
                assets {{ customer.assets_count }}
            </div>

            <div v-if="!compact" class="w-fit md:w-2/12">
                <Badge :theme="statusColorMap[customer.status]">
                    {{ customer.status }}
                </Badge>
            </div>
        </StackedListItem>
    </StackedList>
</template>
