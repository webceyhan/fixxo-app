<script setup>
import { formatDate } from "@/Shared/utils";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import DeviceBadge from "./DeviceBadge.vue";

const props = defineProps({
  devices: Array,
  compact: Boolean,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="device in devices"
      :key="device.id"
      :icon="device.type"
      :href="route('devices.show', device.id)"
    >
      <div class="w-full">
        <div>{{ device.brand }} {{ device.model }}</div>

        <div
          v-if="device.customer"
          class="text-sm text-gray-400 line-clamp-2"
          :class="{ 'max-md:line-clamp-1': compact }"
          v-html="device.customer.name"
        />
      </div>

      <!-- <div
        v-if="device.tasks_count != undefined"
        class="hidden md:block w-2/12 text-gray-400"
      >
        tasks {{ device?.tasks_count ?? 0 }}
      </div>

      <div
        v-if="device.total_cost != undefined"
        class="hidden md:block w-2/12 text-gray-400"
      >
        cost {{ formatMoney(device.total_cost) }}
      </div>

      <div
        v-if="device.balance != undefined"
        class="hidden md:block w-2/12 text-gray-400 whitespace-nowrap text-end"
      >
        {{ formatMoney(device.balance) }}
      </div> -->

      <template #badge>
        <DeviceBadge :status="device.status" compact-max="xl" />
      </template>

      <template #timestamp>
        <div v-if="!compact" class="max-md:hidden whitespace-nowrap text-gray-400">
          {{ formatDate(device.created_at) }}
        </div>
      </template>
    </StackedListItem>
  </StackedList>
</template>
