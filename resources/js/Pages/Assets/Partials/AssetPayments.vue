<script setup>
import { computed, ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PaymentList from "@/Pages/Payments/Partials/PaymentList.vue";
import PaymentModal from "@/Pages/Payments/Partials/PaymentModal.vue";

const props = defineProps({
  asset: Object,
  payments: Array,
});

// Payment Modal
const modal = ref(null);
const editing = ref(null);

// Calculate balance
const balance = computed(() => {
  const cost = props.asset.cost;

  const sumByType = props.payments.reduce((acc, { type, amount }) => {
    acc[type] = (acc[type] || 0) + +amount;
    return acc;
  }, {});

  const { charge, refund, discount, warranty } = sumByType;

  const total =
    (charge ?? 0) - cost + (Math.abs(discount ?? 0) + Math.abs(warranty ?? 0));

  return {
    cost,
    charge,
    discount,
    warranty,
    refund,
    total,
  };
});

const create = () => {
  edit({ asset_id: props.asset.id });
};

const edit = (payment) => {
  editing.value = payment;
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
      <SecondaryButton label="New Payment" icon="create" @click="create" small />
    </template>

    <PaymentList :payments="payments" @select="edit" />
    <PaymentModal :payment="editing" ref="modal" />

    <template #footer>
      <div class="w-full text-right">
        <div class="flex">
          <span class="w-full">cost</span>
          <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
            {{ formatMoney(balance.cost) }}
          </span>
        </div>

        <template
          v-for="type in ['discount', 'warranty', 'charge', 'refund']"
          :key="type"
        >
          <div v-if="balance[type]" class="flex">
            <span class="w-full">{{ type }}</span>
            <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
              {{ formatMoney(balance[type]) }}
            </span>
          </div>
        </template>

        <div class="flex">
          <span
            class="w-full mr-7 sm:mr-9 text-xl mt-1 text-white/50"
            :class="{ '!text-red-500': balance.total < 0 }"
          >
            {{ formatMoney(balance.total) }}
          </span>
        </div>
      </div>
    </template>
  </Card>
</template>
