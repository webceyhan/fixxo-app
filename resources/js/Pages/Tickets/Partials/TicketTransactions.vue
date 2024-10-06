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
const modal = ref(null);
const editing = ref(null);

const create = () => {
  edit({ invoice_id: props.invoice.id });
};

const edit = (transaction) => {
  editing.value = transaction;
  modal.value.open();
};

defineExpose({
  create,
  edit,
});
</script>

<template>
  <Card label="Balance" flush>
    <template #header-action>
      <SecondaryButton label="New Transaction" icon="create" @click="create" small />
    </template>

    <TransactionList :transactions="transactions" @select="edit" />
    <TransactionModal ref="modal" :transaction="editing" :can-delete="canDelete" />

    <template #footer>
      <div class="w-full text-right">
        <div class="flex">
          <span class="w-full">Total Task Cost</span>
          <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
            {{ formatMoney(invoice.tasks_cost) }}
          </span>
        </div>

        <div v-if="invoice.orders_cost" class="flex">
          <span class="w-full">Total Orders Cost</span>
          <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
            {{ formatMoney(invoice.orders_cost) }}
          </span>
        </div>

        <div class="flex">
          <span class="w-full">Total Paid</span>
          <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
            {{ formatMoney(invoice.total_paid) }}
          </span>
        </div>

        <div class="flex">
          <span
            class="w-full mr-7 sm:mr-9 text-xl mt-1 text-white/50"
            :class="{ '!text-red-500': invoice.balance < 0 }"
          >
            {{ formatMoney(invoice.balance) }}
          </span>
        </div>
      </div>
    </template>
  </Card>
</template>
