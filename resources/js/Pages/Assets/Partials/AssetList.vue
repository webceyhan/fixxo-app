<script setup>
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

const props = defineProps({
    assets: Array,
    compact: Boolean,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="asset in assets"
            :key="asset.id"
            :href="route('assets.show', asset.id)"
        >
            <div class="w-full" :class="{ 'md:w-3/6': !compact }">
                {{ asset.brand }}
                {{ asset.name }}

                <div v-if="asset.customer" class="text-sm text-gray-400 mt-1">
                    {{ asset.customer.name }}
                </div>
            </div>

            <div
                v-if="!compact && asset.tasks_count"
                class="hidden md:block w-1/6 text-gray-400"
            >
                tasks {{ asset.tasks_count }}
            </div>

            <div
                v-if="!compact && asset.total_cost"
                class="hidden md:block w-1/6 text-gray-400"
            >
                cost {{ asset.total_cost }}€
            </div>

            <div v-if="!compact" class="w-fit md:w-1/6">
                <span
                    class="px-2.5 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-sm"
                >
                    {{ asset.status }}
                </span>
            </div>
        </StackedListItem>
    </StackedList>
</template>
