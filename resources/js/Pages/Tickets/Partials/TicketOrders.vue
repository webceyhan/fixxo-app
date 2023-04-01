<script setup>
import { ref, computed } from "vue";
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

const totalCost = computed(() => props.orders.reduce((a, b) => a + +b.cost, 0));

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
      <h5>
        Orders
        <span class="ml-1 opacity-50">
          {{ ticket.received_orders_count }}/{{ ticket.total_orders_count }}
        </span>
      </h5>
    </template>

    <template #header-action>
      <SecondaryButton label="New Order" icon="create" @click="create" small />
    </template>

    <OrderList :orders="orders" @select="edit" />
    <OrderModal ref="modal" :order="editing" :can-delete="canDelete" />

    <template #footer>
      <span class="w-full text-right">Total Cost</span>
      <span class="w-2/3 mr-7 sm:mr-9 text-right">
        {{ formatMoney(totalCost) }}
      </span>
    </template>
  </Card>
</template>
