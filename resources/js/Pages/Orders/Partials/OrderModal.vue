<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import OrderForm from "./OrderForm.vue";

defineProps({
  order: Object,
  canDelete: Boolean,
});

const modal = ref(null);

defineExpose({
  open: () => modal.value.open(),
  close: () => modal.value.close(),
});
</script>

<template>
  <Modal ref="modal" size="xl">
    <template #title>
      <span v-if="order?.id"> Edit Order #{{ order.id }} </span>
      <span v-else> Create Order </span>
    </template>

    <template #default="{ close }">
      <OrderForm :order="order" @dismiss="close" dismissable :deletable="canDelete" />
    </template>
  </Modal>
</template>
