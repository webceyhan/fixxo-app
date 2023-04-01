<script setup>
import { formatDate } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import CustomerBadge from "./CustomerBadge.vue";

defineProps({
  customers: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="customer in customers"
      :key="customer.id"
      :href="route('customers.show', customer.id)"
    >
      <template #avatar>
        <Avatar icon="person" class="opacity-75" />
      </template>

      <template #badge>
        <CustomerBadge :status="customer.status" compact />
      </template>

      <TableData :value="customer.name" :label="customer.email" label-class="xl:hidden" />

      <TableData class="max-xl:hidden" :label="customer.email" :value="customer.phone" />

      <TableData
        class="max-xl:hidden text-end"
        label="Devices"
        :value="customer.devices_count"
      />

      <TableData
        class="max-xl:hidden text-end"
        label="Tickets"
        :value="customer.tickets_count"
      />

      <TableData class="max-lg:hidden text-end">
        <CustomerBadge :status="customer.status" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <template #label>
          {{ formatDate(customer.created_at) }}
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
