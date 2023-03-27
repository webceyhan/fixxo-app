<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import PaymentBadge from "./PaymentBadge.vue";

defineEmits(["select"]);

defineProps({
  payments: Array,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="payment in payments"
      :key="payment.id"
      icon="payment"
      @click="$emit('select', payment)"
      clickable
    >
      <div class="w-full truncate">
        <span>
          {{ payment.note ?? payment.type }}
        </span>

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          created on {{ formatDate(payment.created_at, false) }} by
          {{ payment.user?.name }}
        </div>
      </div>

      <div class="w-36 order-1 text-gray-400 text-right text-sm">
        {{ formatMoney(payment.amount) }}
      </div>

      <template #badge>
        <PaymentBadge :type="payment.type" compact-max="xl" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
