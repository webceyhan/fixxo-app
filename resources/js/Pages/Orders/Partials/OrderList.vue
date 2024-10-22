<script setup>
import { formatDate, formatMoney } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import List from "@/Components/List/List.vue";
import ListItem from "@/Components/List/ListItem.vue";
import OrderBadge from "./OrderBadge.vue";

defineEmits(["select"]);

defineProps({
  orders: Array,
});
</script>

<template>
  <List>
    <ListItem v-for="order in orders" @click="$emit('select', order)">
      <div class="max-xl:hidden">
        <Avatar icon="order" />
      </div>

      <div class="xl:hidden -me-2">
        <OrderBadge :status="order.status" compact />
      </div>

      <div class="w-full space-y-1">
        <!-- header -->
        <div class="flex items-center gap-4">
          <p class="text-lead line-clamp-1">{{ order.name }}</p>
          <OrderBadge class="max-xl:hidden -me-2" :status="order.status" />
        </div>

        <!-- footer -->
        <div class="max-xl:hidden flex items-center gap-4 text-alt">
          <p>Created on {{ formatDate(order.created_at, true) }}</p>
          <span>{{ formatMoney(order.cost) }}</span>
        </div>
      </div>
    </ListItem>
  </List>
</template>
