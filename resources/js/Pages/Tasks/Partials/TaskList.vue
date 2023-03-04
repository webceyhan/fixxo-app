<script setup>
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

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

            <span v-if="task.asset" class="w-1/5 text-gray-400">
                {{ task.asset.name }}

                <span v-if="task.user">
                    <br />
                    {{ task.user.name }}
                </span>
            </span>

            <span class="w-fit text-gray-400"> {{ task.price }}€ </span>
        </StackedListItem>
    </StackedList>
</template>
