<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    tasks: Object,
    filters: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <template #actions>
            <div class="flex justify-between items-center">
                <Searchbar :filters="filters" />
                <PrimaryButton
                    label="New"
                    :href="route('tasks.create')"
                    class="ml-5 mr-auto"
                />
                <Pagination v-bind="tasks" />
            </div>
        </template>

        <StackedList>
            <StackedListItem
                v-for="task in tasks.data"
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
    </AuthenticatedCrudLayout>
</template>
