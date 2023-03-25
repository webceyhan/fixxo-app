<script setup>
import { ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PaymentList from "@/Pages/Payments/Partials/PaymentList.vue";
import PaymentModal from "@/Pages/Payments/Partials/PaymentModal.vue";

const props = defineProps({
  asset: Object,
  payments: Array,
  canDelete: Boolean,
});

// Payment Modal
const modal = ref(null);
const editing = ref(null);

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
    <PaymentModal ref="modal" :payment="editing" :can-delete="canDelete" />

    <template #footer>
      <div class="w-full text-right">
        <div class="flex">
          <span class="w-full capitalize">cost</span>
          <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
            {{ formatMoney(asset.cost) }}
          </span>
        </div>

        <template
          v-for="type in ['discount', 'warranty', 'charge', 'refund']"
          :key="type"
        >
          <div v-if="asset.balance_map[type]" class="flex">
            <span class="w-full capitalize">{{ type }}</span>
            <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
              {{ formatMoney(asset.balance_map[type]) }}
            </span>
          </div>
        </template>

        <div class="flex">
          <span
            class="w-full mr-7 sm:mr-9 text-xl mt-1 text-white/50"
            :class="{ '!text-red-500': asset.balance < 0 }"
          >
            {{ formatMoney(asset.balance) }}
          </span>
        </div>
      </div>
    </template>
  </Card>
</template>
