<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import TicketBadge from "./TicketBadge.vue";

defineProps({
  tickets: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="ticket in tickets"
      :key="ticket.id"
      :href="route('tickets.show', ticket.id)"
      badge-class="lg:!block xl:!hidden"
    >
      <template #avatar>
        <Avatar icon="ticket" class="opacity-75" />
      </template>

      <template #badge>
        <TicketBadge :status="ticket.status" compact />
      </template>

      <TableData
        label-class="line-clamp-2"
        :label="ticket.subject"
        :value="ticket.device.brand + ' ' + ticket.device.name"
      />

      <TableData class="max-md:hidden" label="Tasks">
        <template #value>
          {{ ticket.completed_task_count }}/
          {{ ticket.total_task_count }}
        </template>
      </TableData>

      <TableData
        label="Balance"
        class="max-xl:hidden text-end whitespace-nowrap"
        :value="formatMoney(ticket.balance)"
      />

      <TableData class="max-xl:hidden text-end">
        <TicketBadge :status="ticket.status" />
      </TableData>

      <TableData class="max-sm:hidden text-end">
        <template #label>
          <span class="2xl:hidden">{{ formatDate(ticket.created_at) }}</span>
          <span class="max-2xl:hidden">{{ formatDate(ticket.created_at, true) }}</span>
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
