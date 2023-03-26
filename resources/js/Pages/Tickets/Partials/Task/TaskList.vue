<script setup>
import { Link } from "@inertiajs/vue3";
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import TaskBadge from "./TaskBadge.vue";

defineEmits(["select"]);

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
      @click="$emit('select', task)"
      clickable
    >
      <template #avatar>
        <div class="relative">
          <Link
            as="button"
            method="put"
            :href="route('tasks.update', task.id)"
            :data="{ status: nextState[task.status] }"
            preserve-scroll
            @click.stop
          >
            <Avatar
              :icon="stateIcons[task.status]"
              class="opacity-50 hover:opacity-100"
            />
          </Link>
        </div>
      </template>

      <div class="w-full truncate">
        <span
          class="group-hover:no-underline"
          :class="{ 'line-through': task.status === 'done' }"
        >
          {{ task.description }}
        </span>

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          Created by <strong>{{ task.user.name }}</strong> on
          <em>{{ formatDate(task.created_at, true) }}</em>
        </div>
      </div>

      <div class="w-36 order-1 text-gray-400 text-right text-sm">
        {{ formatMoney(task.price) }}
      </div>

      <template #badge>
        <TaskBadge :status="task.status" compact-max="xl" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
