<script setup>
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    users: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="user in users"
            :key="user.id"
            :href="route('users.show', user.id)"
        >
            <span class="w-2/5">
                {{ user.name }}
            </span>

            <span class="w-1/5 text-gray-400">
                assets {{ user.assets_count }}
            </span>

            <span class="w-1/5 text-gray-400">
                tasks {{ user.tasks_count }}
            </span>
        </StackedListItem>
    </StackedList>
</template>
