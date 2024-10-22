<script setup>
import Modal from "@/Components/Modal.vue";
import TransactionForm from "./TransactionForm.vue";

defineProps({
  transaction: Object,
  canDelete: Boolean,
});
</script>

<template>
  <Modal size="xl">
    <template #title>
      <span v-if="transaction?.id"> Edit Transaction #{{ transaction.id }} </span>
      <span v-else> Create Transaction </span>
    </template>

    <template #default="{ close }">
      <TransactionForm
        v-if="transaction"
        :key="transaction.id"
        :transaction="transaction"
        :deletable="canDelete"
        @dismiss="close"
        dismissable
      />
    </template>
  </Modal>
</template>
