<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import TaskBadge from "./TaskBadge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Avatar from "@/Components/Avatar.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  tasks: Array,
});

const nextState = {
  pending: "done",
  done: "pending",
};

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
      :href="route('tasks.show', task.id)"
    >
      <template #avatar>
        <div class="relative">
          <Link
            as="button"
            method="put"
            :href="route('tasks.update', task.id)"
            :data="{ status: nextState[task.status] }"
            preserve-scroll
          >
            <Avatar
              :icon="stateIcons[task.status]"
              class="opacity-50 hover:opacity-100"
            />
          </Link>

          <TaskBadge :status="task.status" compact class="absolute -left-1 -bottom-1" />
        </div>
      </template>

      <template #menu>
        <DangerButton
          label="Delete"
          icon="delete"
          method="delete"
          :href="route('tasks.destroy', task.id)"
        />
      </template>

      <div class="w-full md:w-8/12">
        <span
          :class="{
            'opacity-75 line-through hover:no-underline': task.status === 'done',
          }"
        >
          {{ task.description }}
        </span>

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          created on {{ formatDate(task.created_at, false) }} by
          {{ task.user.name }}
        </div>
      </div>

      <div class="hidden md:block w-2/12 text-gray-400">
        {{ formatMoney(task.price) }}
      </div>
    </StackedListItem>
  </StackedList>
</template>
