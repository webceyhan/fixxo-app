<script setup>
import { ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import OrderModal from "@/Pages/Orders/Partials/OrderModal.vue";
import OrderList from "@/Pages/Orders/Partials/OrderList.vue";

const props = defineProps({
  ticket: Object,
  orders: Array,
  canDelete: Boolean,
});

// Order Modal
const modal = ref(null);
const editing = ref(null);

const create = () => {
  edit({ ticket_id: props.ticket.id });
};

const edit = (order) => {
  editing.value = order;
  modal.value.open();
};

defineExpose({
  create,
  edit,
});
</script>

<template>
  <Card flush>
    <template #header>
      Orders

      <span class="mr-auto opacity-50">
        {{ ticket.completed_orders_count }}/{{ ticket.total_orders_count }}
      </span>

      <SecondaryButton label="New Order" icon="create" @click="create" small />
    </template>

    <OrderList :orders="orders" @select="edit" />
    <OrderModal ref="modal" :order="editing" :can-delete="canDelete" />

    <template #footer>
      <span class="w-1/4"> Total Cost </span>
      <span class="mr-8">
        {{ formatMoney(ticket.invoice.orders_cost) }}
      </span>
    </template>
  </Card>
</template>
