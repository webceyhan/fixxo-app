<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import { makeStatus } from "./shared";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import InvoiceBadge from "./InvoiceBadge.vue";

defineProps({
  invoices: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="invoice in invoices"
      :href="route('tickets.show', invoice.ticket_id)"
    >
      <TableData class="w-8 pe-0 align-top">
        <Avatar class="max-sm:hidden opacity-75" icon="invoice" />
        <InvoiceBadge class="sm:hidden" :status="makeStatus(invoice)" compact />
      </TableData>

      <TableData>
        <p class="text-lead text-wrap line-clamp-1">
          {{ invoice.ticket.device.brand }} {{ invoice.ticket.device.model }} -
          {{ invoice.ticket.customer.name }}
        </p>
        <p class="text-alt text-wrap line-clamp-2">{{ invoice.ticket.description }}</p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ formatMoney(invoice.total) }}</p>
        <p class="text-alt">Total</p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ formatMoney(invoice.balance) }}</p>
        <p class="text-alt">Balance</p>
      </TableData>

      <TableData class="max-lg:hidden">
        <InvoiceBadge :status="makeStatus(invoice)" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <p class="text-alt">{{ formatDate(invoice.due_date) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
