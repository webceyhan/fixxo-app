<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import TransactionBadge from "./TransactionBadge.vue";

defineEmits(["select"]);

defineProps({
  transactions: Array,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="transaction in transactions"
      :key="transaction.id"
      icon="transaction"
      @click="$emit('select', transaction)"
      clickable
    >
      <div class="w-full truncate">
        <span>
          {{ transaction.note ?? transaction.type }}
        </span>

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          <strong>{{ transaction.user.name }}</strong> -
          <em>{{ formatDate(transaction.created_at, true) }}</em>
        </div>
      </div>

      <div class="w-36 order-1 text-gray-400 text-right text-sm">
        {{ formatMoney(transaction.amount) }}
      </div>

      <template #badge>
        <TransactionBadge :type="transaction.type" compact-max="xl" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
