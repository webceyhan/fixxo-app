<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import List from "@/Components/List/List.vue";
import ListItem from "@/Components/List/ListItem.vue";
import TransactionBadge from "./TransactionBadge.vue";

defineEmits(["select"]);

defineProps({
  transactions: Array,
});
</script>

<template>
  <List>
    <ListItem v-for="transaction in transactions" @click="$emit('select', transaction)">
      <div class="max-xl:hidden">
        <Avatar icon="transaction" />
      </div>

      <div class="xl:hidden -me-2">
        <TransactionBadge :type="transaction.type" compact />
      </div>

      <div class="w-full space-y-1">
        <!-- header -->
        <div class="flex items-center gap-4">
          <span class="text-lead">{{ transaction.method }}</span>
          <span class="xl:hidden text-lead">{{ transaction.type }}</span>
          <TransactionBadge class="max-xl:hidden -me-2" :type="transaction.type" />
        </div>

        <!-- footer -->
        <div class="max-xl:hidden text-alt">
          <p>Created on {{ formatDate(transaction.created_at, true) }}</p>
        </div>
      </div>

      <p class="text-alt">{{ formatMoney(transaction.amount) }}</p>
    </ListItem>
  </List>
</template>
