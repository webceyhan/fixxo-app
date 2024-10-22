<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import OrderForm from "./OrderForm.vue";

defineProps<{
  order: any; // TODO: define Order type
  canDelete: boolean;
}>();
</script>

<template>
  <Modal size="xl">
    <template #title>
      <span v-if="order?.id"> Edit Order #{{ order.id }} </span>
      <span v-else> Create Order </span>
    </template>

    <template #default="{ close }">
      <OrderForm
        v-if="order"
        :key="order.id"
        :order="order"
        :deletable="canDelete"
        @dismiss="close"
        dismissable
      />
    </template>
  </Modal>
</template>
