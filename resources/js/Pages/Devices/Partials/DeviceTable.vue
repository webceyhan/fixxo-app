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
    <TableRow
      v-for="device in devices"
      :key="device.id"
      :href="route('devices.show', device.id)"
      badge-class="lg:!block xl:!hidden"
    >
      <template #avatar>
        <Avatar :icon="device.type" class="opacity-75" />
      </template>

      <template #badge>
        <DeviceBadge :status="device.status" compact />
      </template>

      <TableData
        :label="device.customer.name"
        :value="device.brand + ' ' + device.name"
      />

      <TableData class="max-xl:hidden text-end">
        <DeviceBadge :status="device.status" />
      </TableData>

      <TableData class="max-sm:hidden text-end">
        <template #label>
          <span class="2xl:hidden">{{ formatDate(device.created_at) }}</span>
          <span class="max-2xl:hidden">{{ formatDate(device.created_at, true) }}</span>
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
