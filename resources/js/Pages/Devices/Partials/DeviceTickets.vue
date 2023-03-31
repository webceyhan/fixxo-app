<script setup>
import Card from "@/Components/Card.vue";
import TicketList from "@/Pages/Tickets/Partials/TicketList.vue";

const props = defineProps({
  device: Object,
  tickets: Array,
});
</script>

<template>
  <Card flush>
    <template #header>
      <h5>
        Tickets
        <span class="ml-1 opacity-50">
          {{ device.closed_tickets_count }}/
          {{ device.total_tickets_count }}
        </span>
      </h5>
    </template>

    <TicketList :tickets="device.tickets" />
  </Card>
</template>
