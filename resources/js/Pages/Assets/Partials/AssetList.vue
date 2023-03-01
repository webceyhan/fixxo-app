<script setup>
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

const props = defineProps({
    assets: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="asset in assets"
            :key="asset.id"
            :href="route('assets.show', asset.id)"
        >
            <span class="w-2/5">
                {{ asset.brand }}
                {{ asset.name }}

                <br />

                <span class="text-gray-400">
                    {{ asset.customer.name }}
                </span>
            </span>

            <span class="w-1/5 text-gray-400">
                tasks {{ asset.tasks_count }}
            </span>

            <span class="w-fit text-gray-400">
                cost {{ asset.total_cost }}€
            </span>
        </StackedListItem>
    </StackedList>
</template>
