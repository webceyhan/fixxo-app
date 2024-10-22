<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import OrderBadge from "./OrderBadge.vue";

defineProps({
  orders: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="order in orders"
      :key="order.id"
      :href="route('orders.show', order.id)"
    >
      <template #avatar>
        <Avatar icon="order" class="opacity-75" />
      </template>

      <template #badge>
        <OrderBadge :status="order.status" compact />
      </template>

      <TableData :value="order.name">
        <template #label>
          for {{ order.ticket.device.brand }}
          {{ order.ticket.device.model }}
          - {{ order.ticket.customer.name }}
        </template>
      </TableData>

      <TableData
        class="max-xl:hidden text-end"
        :label="`x ${order.quantity}`"
        :value="formatMoney(order.cost)"
      />

      <TableData class="max-lg:hidden text-end">
        <OrderBadge :status="order.status" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <template #label>
          {{ formatDate(order.created_at) }}
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
