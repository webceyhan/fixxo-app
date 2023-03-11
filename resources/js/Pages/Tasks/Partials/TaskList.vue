<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import TaskBadge from "./TaskBadge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

defineProps({
  tasks: Array,
});

const stateIcons = {
  pending: "clipboard",
  done: "clipboard-check",
};
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="task in tasks"
      :key="task.id"
      :icon="stateIcons[task.status]"
      :href="route('tasks.show', task.id)"
    >
      <template #menu>
        <ToggleButton
          name="status"
          :value="task.status"
          :href="route('tasks.update', task.id)"
          :options="{
            pending: 'Uncheck',
            done: 'Check',
          }"
          :icons="{
            pending: 'clipboard',
            done: 'clipboard-check',
          }"
          method="put"
        />

        <DangerButton
          label="Delete"
          icon="delete"
          method="delete"
          :href="route('tasks.destroy', task.id)"
        />
      </template>

      <div class="w-full md:w-8/12">
        {{ task.description }}

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          created on {{ formatDate(task.created_at, false) }} by
          {{ task.user.name }}
        </div>
      </div>

      <div class="hidden md:block w-2/12 text-gray-400">
        {{ formatMoney(task.price) }}
      </div>

      <template #badge>
        <TaskBadge :status="task.status" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
