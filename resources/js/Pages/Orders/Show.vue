<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import TicketCard from "@/Pages/Tickets/Partials/TicketCard.vue";
import OrderForm from "./Partials/OrderForm.vue";

const props = defineProps({
  ticket: Object,
  order: Object,
  canDelete: Boolean,
});
</script>

<template>
  <PageLayout :title="`Order #${order.id}`">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton
        label="Edit"
        icon="edit"
        :href="route('orders.edit', order.id)"
      />
      <DangerButton
        v-if="canDelete"
        label="Delete"
        method="delete"
        icon="delete"
        :href="route('orders.destroy', order.id)"
        class="mr-4"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem
          label="Edit"
          icon="edit"
          :href="route('orders.edit', order.id)"
        />
        <DropdownItem
          v-if="canDelete"
          label="Delete"
          method="delete"
          icon="delete"
          :href="route('orders.destroy', order.id)"
        />
      </Dropdown>
    </template>

    <template #aside>
      <TicketCard :ticket="ticket" />
    </template>

    <template #content>
      <!-- <Card label="Order" flush> -->
        <OrderForm :order="order" />
      <!-- </Card> -->
    </template>
  </PageLayout>
</template>
