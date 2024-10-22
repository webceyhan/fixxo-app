<script setup>
import { formatDate } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import List from "@/Components/List/List.vue";
import ListItem from "@/Components/List/ListItem.vue";
import DeviceBadge from "./DeviceBadge.vue";

const props = defineProps({
  devices: Array,
});
</script>

<template>
  <List>
    <ListItem v-for="device in devices" :href="route('devices.show', device.id)">
      <div class="max-xl:hidden">
        <Avatar :icon="device.type" />
      </div>

      <div class="xl:hidden -me-2">
        <DeviceBadge :status="device.status" compact />
      </div>

      <div class="w-full space-y-1">
        <!-- header -->
        <p class="text-lead">{{ device.brand }} {{ device.model }}</p>

        <!-- footer -->
        <p class="max-xl:hidden text-alt">
          Created on {{ formatDate(device.created_at, true) }}
        </p>
      </div>

      <div class="max-xl:hidden">
        <DeviceBadge :status="device.status" />
      </div>
    </ListItem>
  </List>
</template>
