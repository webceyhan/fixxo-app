<script setup>
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

      <TableData>
        {{ customer.name }}
      </TableData>

      <TableData class="max-xl:hidden" :label="customer.email" :value="customer.phone" />

      <TableData
        class="max-xl:hidden text-end !pr-28"
        label="Assets"
        :value="customer.assets_count"
      />

      <TableData class="max-lg:hidden">
        <CustomerBadge :status="customer.status" />
      </TableData>
    </TableRow>
  </Table>
</template>
