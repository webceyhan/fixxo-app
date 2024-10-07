<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import TicketBadge from "./TicketBadge.vue";
import PriorityBadge from "./PriorityBadge.vue";

defineProps({
  tickets: Array,
});
</script>

<template>
  <Table>
    <TableRow v-for="ticket in tickets" :href="route('tickets.show', ticket.id)">
      <TableData class="w-8 pe-0 align-top">
        <Avatar class="max-sm:hidden opacity-75" icon="ticket" />
        <TicketBadge class="sm:hidden" :status="ticket.status" compact />
      </TableData>

      <TableData>
        <p class="text-lead">{{ ticket.device.brand }} {{ ticket.device.model }}</p>
        <p class="text-alt text-wrap line-clamp-2">{{ ticket.description }}</p>
      </TableData>

      <TableData class="max-xl:hidden text-end">
        <PriorityBadge :value="ticket.priority" />
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ ticket.completed_tasks_count }}/{{ ticket.total_tasks_count }}</p>
        <p class="text-alt">Tasks</p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ ticket.completed_orders_count }}/{{ ticket.total_orders_count }}</p>
        <p class="text-alt">Orders</p>
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <p>{{ formatMoney(ticket.balance) }}</p>
        <p class="text-alt">Balance</p>
      </TableData>

      <TableData class="max-xl:hidden text-end">
        <TicketBadge :status="ticket.status" />
      </TableData>

      <TableData class="max-sm:hidden text-end">
        <p class="text-alt">{{ formatDate(ticket.created_at) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
