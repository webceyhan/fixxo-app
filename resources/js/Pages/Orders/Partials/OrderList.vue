<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";
import OrderBadge from "./OrderBadge.vue";

defineEmits(["select"]);

defineProps({
  orders: Array,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="order in orders"
      :key="order.id"
      icon="order"
      @click="$emit('select', order)"
      clickable
    >
      <div class="w-full truncate">
        {{ order.name }}

        <div class="hidden md:block text-gray-400 text-sm mt-1">
          <strong>{{ order.user.name }}</strong> -
          <em>{{ formatDate(order.created_at, true) }}</em>
        </div>
      </div>

      <div class="w-36 order-1 text-gray-400 text-right text-sm">
        {{ formatMoney(order.cost) }}
      </div>

      <template #badge>
        <OrderBadge :status="order.status" compact-max="xl" />
      </template>
    </StackedListItem>
  </StackedList>
</template>
