<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Progress from "@/Components/Progress.vue";
import List from "@/Components/List/List.vue";
import ListItem from "@/Components/List/ListItem.vue";
import TicketBadge from "./TicketBadge.vue";

const props = defineProps({
  tickets: Array,
  compact: Boolean,
  withBalance: Boolean,
  withTaskCount: Boolean,
});
</script>

<template>
  <List>
    <ListItem v-for="ticket in tickets" :href="route('tickets.show', ticket.id)">
      <!-- COMPACT VIEW //////////////////////////////////////////////////////////////////////// -->
      <template v-if="compact">
        <div class="max-xl:hidden">
          <Avatar icon="ticket" />
        </div>

        <div class="w-full space-y-1">
          <!-- header -->
          <div class="flex items-center gap-4">
            <span class="text-lead">
              {{ ticket.device.brand }} {{ ticket.device.model }}
            </span>

            <TicketBadge :status="ticket.status" compact />

            <p class="text-alt text-end">{{ formatDate(ticket.created_at) }}</p>
          </div>

          <!-- footer -->
          <div class="flex items-center gap-4 text-alt">
            <p class="line-clamp-1">{{ ticket.description }}</p>

            <Progress
              v-if="withTaskCount"
              class="h-1 w-14 shrink-0"
              :value="ticket.completed_tasks_count"
              :max="ticket.total_tasks_count"
            />

            <p v-if="withBalance" class="text-nowrap text-end">
              {{ formatMoney(ticket.balance) }}
            </p>
          </div>
        </div>
      </template>

      <!-- NORMAL VIEW ///////////////////////////////////////////////////////////////////////// -->
      <template v-else>
        <div class="max-xl:hidden">
          <Avatar icon="ticket" />
        </div>

        <div class="xl:hidden -me-2">
          <TicketBadge :status="ticket.status" compact />
        </div>

        <div class="w-full space-y-1">
          <!-- header -->
          <p class="line-clamp-1">{{ ticket.description }}</p>

          <!-- footer -->
          <p class="max-sm:hidden text-alt">
            Created on {{ formatDate(ticket.created_at, true) }}
          </p>
        </div>

        <div class="max-xl:hidden">
          <TicketBadge :status="ticket.status" />
        </div>
      </template>
    </ListItem>
  </List>
</template>
