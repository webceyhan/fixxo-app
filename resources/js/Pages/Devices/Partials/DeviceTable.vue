<script setup>
import { formatDate } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import DeviceBadge from "./DeviceBadge.vue";

defineProps({
  devices: Array,
});
</script>

<template>
  <Table>
    <TableRow v-for="device in devices" :href="route('devices.show', device.id)">
      <TableData class="w-8 pe-0 align-top">
        <Avatar class="max-sm:hidden opacity-75" :icon="device.type" />
        <DeviceBadge class="sm:hidden" :status="device.status" compact />
      </TableData>

      <TableData>
        <p class="text-lead">{{ device.brand }} {{ device.model }}</p>
        <p class="text-alt">{{ device.customer.name }}</p>
      </TableData>

      <TableData class="max-md:hidden" label="Tickets">
        <p>{{ device.completed_tickets_count }}/{{ device.tickets_count }}</p>
        <p class="text-alt">Tickets</p>
      </TableData>

      <TableData class="max-xl:hidden text-end">
        <DeviceBadge :status="device.status" />
      </TableData>

      <TableData class="max-sm:hidden text-end">
        <p class="text-alt">{{ formatDate(device.created_at) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
