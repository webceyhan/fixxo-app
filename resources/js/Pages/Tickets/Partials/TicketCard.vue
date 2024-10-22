<script setup>
import Card from "@/Components/Card.vue";
import Field from "@/Components/Field/Field.vue";
import FieldGroup from "@/Components/Field/FieldGroup.vue";
import LinkField from "@/Components/Field/LinkField.vue";
import DateField from "@/Components/Field/DateField.vue";
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

    <FieldGroup>
      <!-- TODO: Add the following fields as link -->
      <!-- customer_id: Owner -->
      <!-- user_id: Receiver -->

      <LinkField
        v-if="ticket.customer"
        label="Customer"
        :href="route('customers.show', ticket.customer.id)"
        :value="ticket.customer.name"
      />

      <LinkField
        label="Device"
        :href="route('devices.show', ticket.device.id)"
        :value="ticket.device.brand + ' ' + ticket.device.model"
      />

      <LinkField
        label="Type"
        :href="route('tickets.index', { type: ticket.type })"
        :value="ticket.device.type"
      />

      <Field label="Priority">
        <PriorityBadge :value="ticket.priority" />
      </Field>

      <Field
        v-if="ticket.serial_number"
        label="Serial Number"
        :value="ticket.serial_number"
      />

      <DateField
        v-if="ticket.purchase_date"
        label="Purchase Date"
        :value="ticket.purchase_date"
        short
      />

      <DateField
        v-if="ticket.warranty_date"
        label="Warranty Expire Date"
        :value="ticket.warranty_date"
        short
      />

      <DateField label="Due Date" :value="ticket.due_date" />

      <DateField label="Created At" :value="ticket.created_at" />

      <DateField
        v-if="ticket.returned_at"
        label="Returned At"
        :value="ticket.returned_at"
      />

      <DateField label="Last Update" :value="ticket.updated_at" />

      <Field v-if="ticket.assignee" label="Assignee" :value="ticket.assignee?.name" />
    </FieldGroup>
  </Card>
</template>
