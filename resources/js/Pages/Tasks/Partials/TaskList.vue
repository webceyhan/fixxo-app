<script setup>
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    tasks: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="task in tasks"
            :key="task.id"
            :href="route('tasks.show', task.id)"
        >
            <span class="w-2/5">
                {{ task.description }}
            </span>

            <span class="w-1/5 text-gray-400">
                {{ task.asset.name }}

                <br />

                {{ task.user.name }}
            </span>

            <span class="w-fit text-gray-400"> {{ task.price }}€ </span>
        </StackedListItem>
    </StackedList>
</template>
