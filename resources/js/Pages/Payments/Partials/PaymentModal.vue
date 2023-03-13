<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import PaymentForm from "./PaymentForm.vue";

defineProps({
  payment: Object,
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
      <span v-if="payment?.id"> Edit Payment #{{ payment.id }} </span>
      <span v-else> Create Payment </span>
    </template>

    <template #default="{ close }">
      <PaymentForm :payment="payment" @dismiss="close" dismissable deletable />
    </template>
  </Modal>
</template>
