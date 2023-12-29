<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import TicketBadge from "./TicketBadge.vue";

const props = defineProps({
  tickets: Array,
  compact: Boolean,
  withBalance: Boolean,
  withTaskCount: Boolean,
});

function getProgress(ticket) {
  const { completed_tasks_count, total_tasks_count } = ticket;

  if (completed_tasks_count == 0) return 0;

  if (completed_tasks_count == total_tasks_count) return 100;

  return Math.round((completed_tasks_count / total_tasks_count) * 100);
}
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="ticket in tickets"
      :key="ticket.id"
      :href="route('tickets.show', ticket.id)"
    >
      <template #avatar>
        <Avatar icon="ticket" class="flex-shrink-0 opacity-50" />
        <div v-if="compact" class="absolute left-8 bottom-6 text-center">
          <TicketBadge :status="ticket.status" compact />
        </div>
      </template>

      <div class="w-full">
        <div v-if="ticket.device">
          {{ ticket.device.brand }}
          {{ ticket.device.model }}
        </div>

        <div
          class="text-sm text-gray-400"
          :class="{
            'line-clamp-2': !compact,
            'line-clamp-1': compact,
          }"
          v-html="ticket.description"
        />
      </div>

      <div
        v-if="withTaskCount"
        class="w-2/12 text-gray-400 whitespace-nowrap text-sm text-end"
      >
        {{ ticket.completed_tasks_count }}/{{ ticket.total_tasks_count }}
        <ProgressBar :value="getProgress(ticket)" class="mt-1" />
      </div>

      <div v-if="withBalance" class="w-2/12 text-gray-400 whitespace-nowrap text-end">
        {{ formatMoney(ticket.balance) }}
      </div>

      <template v-if="!compact" #badge>
        <TicketBadge :status="ticket.status" compact-max="xl" />
      </template>

      <template #timestamp>
        <div v-if="!compact" class="max-md:hidden whitespace-nowrap text-gray-400">
          {{ formatDate(ticket.created_at) }}
        </div>
      </template>
    </StackedListItem>
  </StackedList>
</template>
