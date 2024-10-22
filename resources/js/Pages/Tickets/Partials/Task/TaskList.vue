<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import List from "@/Components/List/List.vue";
import ListItem from "@/Components/List/ListItem.vue";
import TaskBadge from "./TaskBadge.vue";

defineEmits<{
  (e: "select", task: any): void;
}>();

defineProps<{
  tasks: any[]; // TODO: define Task type
}>();

// TODO: extract to shared file
const stateIcons: Record<string, string> = {
  new: "clipboard",
  completed: "clipboard-check",
  cancelled: "clipboard-x",
};
</script>

<template>
  <List>
    <ListItem v-for="task in tasks" @click="$emit('select', task)">
      <div class="max-xl:hidden">
        <Link
          as="button"
          method="put"
          :href="route('tasks.update', task.id)"
          :data="{ status: task.status === 'completed' ? 'new' : 'completed' }"
          preserve-scroll
          @click.stop
        >
          <Avatar :icon="stateIcons[task.status]" />
        </Link>
      </div>

      <div class="xl:hidden -me-2">
        <TaskBadge :status="task.status" compact />
      </div>

      <div class="w-full space-y-1">
        <!-- header -->
        <div class="flex items-center gap-4">
          <p class="text-lead line-clamp-1">{{ task.description }}</p>
          <TaskBadge class="max-xl:hidden -me-2" :status="task.status" />
        </div>

        <!-- footer -->
        <div class="max-xl:hidden flex items-center gap-4 text-alt">
          <p>Created on {{ formatDate(task.created_at, true) }}</p>
          <span>{{ formatMoney(task.cost) }}</span>
        </div>
      </div>
    </ListItem>
  </List>
</template>
