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
      Tickets

      <span class="mr-auto opacity-50">
        {{ device.closed_tickets_count }}/{{ device.total_tickets_count }}
      </span>
    </template>

    <TicketList :tickets="device.tickets" />
  </Card>
</template>
