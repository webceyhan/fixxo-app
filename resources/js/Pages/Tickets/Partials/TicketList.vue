<script setup>
import { formatDate } from "@/Shared/utils";
import TicketBadge from "./TicketBadge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

const props = defineProps({
  tickets: Array,
  compact: Boolean,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="ticket in tickets"
      :key="ticket.id"
      icon="ticket"
      :href="route('tickets.show', ticket.id)"
    >
      <div class="w-full">
        <div v-if="ticket.device">
          {{ ticket.device.brand }}
          {{ ticket.device.name }}
        </div>

        <div class="text-sm text-gray-400 line-clamp-2" 
        :class="{'max-md:line-clamp-1': compact}"
        
        v-html="ticket.subject" />
      </div>

      <!-- <div
        v-if="ticket.tasks_count != undefined"
        class="hidden md:block w-2/12 text-gray-400"
      >
        tasks {{ ticket?.tasks_count ?? 0 }}
      </div>

      <div
        v-if="ticket.total_cost != undefined"
        class="hidden md:block w-2/12 text-gray-400"
      >
        cost {{ formatMoney(ticket.total_cost) }}
      </div>

      <div
        v-if="ticket.balance != undefined"
        class="hidden md:block w-2/12 text-gray-400 whitespace-nowrap text-end"
      >
        {{ formatMoney(ticket.balance) }}
      </div> -->

      <template #badge>
        <TicketBadge :status="ticket.status"  compact-max="xl" />
      </template>

      <template #timestamp>
        <div v-if="!compact" class="max-md:hidden whitespace-nowrap text-gray-400">
          {{ formatDate(ticket.created_at) }}
        </div>
      </template>
    </StackedListItem>
  </StackedList>
</template>
