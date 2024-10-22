<script setup lang="ts">
import { ComponentPublicInstance, ref } from "vue";
import PageLayout from "@/Layouts/PageLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";
import TicketCard from "@/Pages/Tickets/Partials/TicketCard.vue";
import OrderForm from "./Partials/OrderForm.vue";

const props = defineProps<{
  order: any; // TODO: define Order type
  ticket: any; // TODO: define Ticket type
  canDelete: boolean;
}>();

const orderForm = ref<ComponentPublicInstance<typeof OrderForm> | null>(null);
</script>

<template>
  <PageLayout :title="`Order #${order.id}`">
    <!-- desktop menu -->
    <template #desktop-menu>
      <PrimaryButton label="Save" icon="save" @click="orderForm?.save()" />

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
      <Dropdown align-end>
        <MenuLink label="Save" icon="save" @click="orderForm?.save()" />
        <MenuLink
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
