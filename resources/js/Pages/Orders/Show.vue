<script setup>
import { ref } from "vue";
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import TicketCard from "@/Pages/Tickets/Partials/TicketCard.vue";
import OrderForm from "./Partials/OrderForm.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
  ticket: Object,
  order: Object,
  canDelete: Boolean,
});

const orderForm = ref(null);
</script>

<template>
  <PageLayout :title="`Order #${order.id}`">
    <!-- desktop menu -->
    <template #desktop-menu>
      <PrimaryButton label="Save" icon="save" @click="orderForm.save()" />

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
        <DropdownItem label="Save" icon="save" @click="orderForm.save()" />
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
      <OrderForm :order="order" ref="orderForm" no-actions />
    </template>
  </PageLayout>
</template>
