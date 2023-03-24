<script setup>
import { formatNumber } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";
import StatCardChart from "./StatCardChart.vue";

const props = defineProps({
  label: String,
  icon: String,
  value: [String, Number],
  labels: Array,
  values: Array,
  iconBgColor: String,
});
</script>

<template>
  <Card class="relative">
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
    <StatCardChart :labels="labels" :values="values" :color-class="iconBgColor" />
  </Card>
</template>
