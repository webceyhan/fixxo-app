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
    <TableRow v-for="order in orders" :href="route('orders.show', order.id)">
      <TableData class="w-8 pe-0 align-top">
        <Avatar class="max-sm:hidden opacity-75" icon="order" />
        <OrderBadge class="sm:hidden" :status="order.status" compact />
      </TableData>

      <TableData>
        <p class="text-lead">{{ order.name }}</p>
        <p class="text-alt">
          for {{ order.ticket.device.brand }} {{ order.ticket.device.model }} -
          {{ order.ticket.customer.name }}
        </p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ formatMoney(order.cost) }}</p>
        <p class="text-alt">x {{ order.quantity }}</p>
      </TableData>

      <TableData class="max-lg:hidden">
        <p>{{ formatMoney(order.cost * order.quantity) }}</p>
        <p class="text-alt">Total</p>
      </TableData>

      <TableData class="max-lg:hidden">
        <OrderBadge :status="order.status" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <p class="text-alt">{{ formatDate(order.created_at) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
