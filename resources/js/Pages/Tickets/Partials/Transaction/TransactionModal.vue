<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import TransactionForm from "./TransactionForm.vue";

defineProps({
  transaction: Object,
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
      <span v-if="transaction?.id"> Edit Transaction #{{ transaction.id }} </span>
      <span v-else> Create Transaction </span>
    </template>

    <template #default="{ close }">
      <TransactionForm
        @dismiss="close"
        :transaction="transaction"
        :deletable="canDelete"
        dismissable
      />
    </template>
  </Modal>
</template>
