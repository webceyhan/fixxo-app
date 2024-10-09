<script setup>
import { formatDate } from "@/Shared/utils";
import Timeline from "@/Components/Timeline/Timeline.vue";
import TimelineItem from "@/Components/Timeline/TimelineItem.vue";
import DeviceBadge from "./DeviceBadge.vue";

const props = defineProps({
  logs: Array,
});
</script>

<template>
  <h2 class="text-xl font-semibold">History</h2>

  <Timeline vertical>
    <TimelineItem v-for="log in logs" :time="formatDate(log.created_at, true)">
      <p>
        {{ log.user.name }}
        <span class="text-base-content/60">changed status to</span>
        <DeviceBadge :status="log.status" />
      </p>
    </TimelineItem>
  </Timeline>
</template>
