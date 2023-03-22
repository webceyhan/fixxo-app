<script setup>
import { formatNumber } from "@/Shared/utils";
import Card from "./Card.vue";
import Icon from "./Icon.vue";

const props = defineProps({
  label: String,
  icon: String,
  value: [String, Number],
  iconBgColor: String,
});
</script>

<template>
  <Card>
    <div class="flex items-center gap-x-5">
      <div
        class="flex items-center justify-center w-14 h-14 rounded-full"
        :class="iconBgColor"
      >
        <Icon :name="icon" class="text-3xl text-white" />
      </div>

      <div>
        <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">
          <slot>{{ formatNumber(value) }}</slot>
        </h4>
        <div class="text-gray-500">
          {{ label }}
        </div>
      </div>
    </div>
  </Card>
</template>
