<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import InvoiceBadge from "./InvoiceBadge.vue";
import { makeStatus } from "./shared";

defineProps({
  invoices: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="invoice in invoices"
      :key="invoice.id"
      :href="route('tickets.show', invoice.ticket_id)"
    >
      <template #avatar>
        <Avatar icon="invoice" class="opacity-75" />
      </template>

      <template #badge>
        <InvoiceBadge :status="makeStatus(invoice)" compact />
      </template>

      <TableData>
        <template #value>
          <div class="truncate max-w-xl">
            {{ invoice.ticket.description }}
          </div>
        </template>
        <template #label>
          for {{ invoice.ticket.device.brand }}
          {{ invoice.ticket.device.model }}
          - {{ invoice.ticket.customer.name }}
        </template>
      </TableData>

      <TableData
        class="max-xl:hidden text-end"
        label="Total"
        :value="formatMoney(invoice.total)"
      />

      <TableData
        class="max-xl:hidden text-end"
        label="Balance"
        :value="formatMoney(invoice.balance)"
      />

      <TableData class="max-lg:hidden text-end">
        <InvoiceBadge :status="makeStatus(invoice)" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <template #label>
          {{ formatDate(invoice.due_date) }}
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
