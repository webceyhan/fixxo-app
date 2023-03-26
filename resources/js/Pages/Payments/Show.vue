<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PaymentCard from "./Partials/PaymentCard.vue";
import TicketCard from "../Tickets/Partials/TicketCard.vue";

const props = defineProps({
  payment: Object,
});
</script>

<template>
  <PageLayout :title="payment.type" content-only-mobile>
    <template #toolbar>
      <SecondaryButton
        label="Edit"
        icon="edit"
        :href="route('payments.edit', payment.id)"
      />
      <DangerButton
        label="Delete"
        icon="delete"
        method="delete"
        :href="route('payments.destroy', payment.id)"
      />
    </template>

    <template #aside>
      <TicketCard :ticket="payment.ticket" />
    </template>

    <template #content>
      <PaymentCard :payment="payment" />
    </template>
  </PageLayout>
</template>
