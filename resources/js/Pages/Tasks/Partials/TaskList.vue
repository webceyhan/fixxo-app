<script setup>
import { Link } from "@inertiajs/vue3";
import { formatDate, formatMoney } from "@/Shared/utils";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import Avatar from "@/Components/Avatar.vue";
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

          <!-- <TaskBadge :status="task.status" compact class="absolute -left-1 -bottom-1" /> -->
        </div>
      </template>

      <div class="w-full truncate">
        <span
          :class="{ 'line-through group-hover:no-underline': task.status === 'done' }"
        >
          {{ task.description }}
        </span>

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          created on {{ formatDate(task.created_at, false) }} by
          {{ task.user.name }}
        </div>
      </div>

      <div class="w-36 order-1 text-gray-400 text-right text-sm">
        {{ formatMoney(task.price) }}
      </div>

      <template #badge>
        <TaskBadge :status="task.status" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
