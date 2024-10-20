<script setup>
import { ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TransactionList from "./Transaction/TransactionList.vue";
import TransactionModal from "./Transaction/TransactionModal.vue";

const props = defineProps({
  invoice: Object,
  transactions: Array,
  canDelete: Boolean,
});

// Transaction Modal
const editing = ref(null);
const modalOpen = ref(false);

const create = () => {
  edit({ invoice_id: props.invoice.id });
};

const edit = (transaction) => {
  editing.value = transaction;
  modalOpen.value = true;
};

defineExpose({
  create,
  edit,
});
</script>

<template>
  <Card flush>
    <template #header>
      Balance

      <SecondaryButton label="New Transaction" icon="create" @click="create" small />
    </template>

    <TransactionList :transactions="transactions" @select="edit" />
    <TransactionModal
      v-model:open="modalOpen"
      :transaction="editing"
      :can-delete="canDelete"
    />

    <template #footer>
      <div class="w-full text-right space-y-1 mr-8">
        <div class="flex">
          <span class="w-full">Total Task Cost</span>
          <span class="w-1/3 border-b border-neutral border-dashed">
            {{ formatMoney(invoice.tasks_cost) }}
          </span>
        </div>

        <div v-if="invoice.orders_cost" class="flex">
          <span class="w-full">Total Orders Cost</span>
          <span class="w-1/3 border-b border-neutral border-dashed">
            {{ formatMoney(invoice.orders_cost) }}
          </span>
        </div>

        <div class="flex">
          <span class="w-full">Total Paid</span>
          <span class="w-1/3 border-b border-neutral border-dashed">
            {{ formatMoney(invoice.total_paid) }}
          </span>
        </div>

        <span :class="['text-xl', { 'text-error': invoice.balance < 0 }]">
          {{ formatMoney(invoice.balance) }}
        </span>
      </div>
    </template>
  </Card>
</template>
