<script setup>
import { formatDate } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import TicketBadge from "./TicketBadge.vue";
import PriorityBadge from "./PriorityBadge.vue";

const props = defineProps({
  ticket: Object,
});
</script>

<template>
  <Card>
    <template #header>
      <div class="w-full relative flex justify-end min-h-6">
        <h5 class="absolute left-0 flex items-center justify-between gap-3">
          <span>Ticket</span>
          <TicketBadge :status="ticket.status" />
        </h5>

        <img
          :src="ticket.qr_url"
          class="z-10 w-10 h-auto -my-2 hover:my-0 hover:w-full opacity-50 hover:opacity-100 transition-all duration-200"
        />
      </div>
    </template>

    <DescriptionList>
      <!-- TODO: Add the following fields as link -->
      <!-- customer_id: Owner -->
      <!-- user_id: Receiver -->

      <DescriptionListItem
        label="Customer"
        v-if="ticket.customer"
        :value="ticket.customer.name"
        :href="route('customers.show', ticket.customer.id)"
      />

      <DescriptionListItem
        label="Device"
        :value="ticket.device.brand + ' ' + ticket.device.model"
        :href="route('devices.show', ticket.device.id)"
      />

      <DescriptionListItem
        label="Type"
        :value="ticket.device.type"
        :href="route('tickets.index', { type: ticket.type })"
      />

      <DescriptionListItem label="Priority">
        <PriorityBadge :value="ticket.priority" />
      </DescriptionListItem>

      <DescriptionListItem
        v-if="ticket.serial_number"
        label="Serial Number"
        :value="ticket.serial_number"
      />

      <DescriptionListItem v-if="ticket.purchase_date" label="Purchase Date">
        {{ formatDate(ticket.purchase_date) }}
      </DescriptionListItem>

      <DescriptionListItem v-if="ticket.warranty_date" label="Warranty Expire Date">
        {{ formatDate(ticket.warranty_date) }}
      </DescriptionListItem>

      <DescriptionListItem label="Created At" type="date" :value="ticket.created_at" />

      <DescriptionListItem
        v-if="ticket.returned_at"
        label="Returned At"
        type="date"
        :value="ticket.returned_at"
      />

      <DescriptionListItem label="Last Update" type="date" :value="ticket.updated_at" />

      <DescriptionListItem label="Last update by">
        {{ ticket.user.name }}
      </DescriptionListItem>
    </DescriptionList>
  </Card>
</template>
