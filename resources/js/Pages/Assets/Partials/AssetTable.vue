<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import AssetBadge from "./AssetBadge.vue";

defineProps({
  assets: Array,
});
</script>

<template>
  <Table>
    <TableRow
      v-for="asset in assets"
      :key="asset.id"
      :href="route('assets.show', asset.id)"
      badge-class="lg:!block xl:!hidden"
    >
      <template #avatar>
        <Avatar :icon="asset.type" class="opacity-75" />
      </template>

      <template #badge>
        <AssetBadge :status="asset.status" compact />
      </template>

      <TableData :label="asset.customer.name" :value="asset.brand + ' ' + asset.name" />

      <TableData class="max-2xl:hidden" label="Tasks" :value="asset.tasks_count" />

      <TableData
        label="Cost"
        class="max-md:hidden text-end"
        :value="formatMoney(asset.total_cost)"
      />

      <TableData class="max-xl:hidden text-end">
        <AssetBadge :status="asset.status" />
      </TableData>

      <TableData class="max-sm:hidden text-end">
        <template #label>
          <span class="2xl:hidden">{{ formatDate(asset.created_at) }}</span>
          <span class="max-2xl:hidden">{{ formatDate(asset.created_at, true) }}</span>
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
