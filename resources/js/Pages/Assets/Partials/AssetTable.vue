<script setup>
import { formatMoney } from "@/Shared/utils";
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
    >
      <template #avatar>
        <Avatar :icon="asset.type" class="opacity-75" />
      </template>

      <template #badge>
        <AssetBadge :status="asset.status" />
      </template>

      <TableData :label="asset.customer.name" :value="asset.brand + ' ' + asset.name" />

      <TableData class="max-xl:hidden" label="Tasks" :value="asset.tasks_count" />

      <TableData
        class="max-md:hidden text-end xl:!pr-28"
        label="Cost"
        :value="formatMoney(asset.total_cost)"
      />

      <TableData class="max-lg:hidden">
        <AssetBadge :status="asset.status" />
      </TableData>
    </TableRow>
  </Table>
</template>
