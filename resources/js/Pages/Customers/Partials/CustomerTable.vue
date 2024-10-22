<script setup lang="ts">
import { formatDate } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";

defineProps<{
  customers: any[]; // TODO: define Customer type
}>();
</script>

<template>
  <Table>
    <TableRow v-for="customer in customers" :href="route('customers.show', customer.id)">
      <TableData class="max-sm:hidden w-8 pe-0 align-top">
        <Avatar class="opacity-75" icon="person" />
      </TableData>

      <TableData>
        <p class="text-lead">{{ customer.name }}</p>
        <p class="text-alt">{{ customer.company }}</p>
      </TableData>

      <TableData class="max-2xl:hidden">
        <p>{{ customer.email }}</p>
        <p class="text-alt">{{ customer.phone }}</p>
      </TableData>

      <TableData class="max-lg:hidden">
        <p>{{ customer.devices_count }}</p>
        <p class="text-alt">Devices</p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ customer.tickets_count }}</p>
        <p class="text-alt">Tickets</p>
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <p class="text-alt">{{ formatDate(customer.created_at) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
