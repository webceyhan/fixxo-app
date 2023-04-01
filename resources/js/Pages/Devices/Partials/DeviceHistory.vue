<script setup>
import { formatDate } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import DeviceBadge from "./DeviceBadge.vue";

const props = defineProps({
  logs: Array,
});
</script>

<template>
  <div class="space-y-6"> 
  <h3 class="text-xl font-semibold dark:text-white pt-4">History</h3>

  <ol class="relative border-l border-gray-50 dark:border-gray-700 space-y-6">
    <li v-for="log in logs" :key="log.id" class="ml-4">
      <div
        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
      ></div>

      <time
        class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
      >
        {{ formatDate(log.created_at, true) }}
      </time>

      <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 space-x-2">
        <span class="text-black dark:text-gray-200">{{ log.user.name }}</span>
        <span>changed status to</span>
        <DeviceBadge :status="log.status" class="dark:!bg-black/25" />
      </p>
    </li>
  </ol>
  </div>
</template>
