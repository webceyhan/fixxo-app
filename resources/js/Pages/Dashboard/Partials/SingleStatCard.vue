<script setup>
import { formatNumber } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import Stat from "@/Components/Stat/Stat.vue";
import StatValue from "@/Components/Stat/StatValue.vue";
import StatFigure from "@/Components/Stat/StatFigure.vue";
import StatTitle from "@/Components/Stat/StatTitle.vue";
import StatCardChart from "./StatCardChart.vue";

/**
 * Colors:
 *
 * text-info
 * text-success
 * text-warning
 * text-error
 */
const props = defineProps({
  label: String,
  icon: String,
  value: [String, Number],
  labels: Array,
  values: Array,
  color: String,
});
</script>

<template>
  <Card class="relative" flush>
    <Stat>
      <StatFigure :icon :class="`text-4xl text-${color}`" />
      <StatValue :text="formatNumber(value)" />
      <StatTitle :text="label" />
    </Stat>
    <StatCardChart :labels :values :color="`text-${color}`" />
  </Card>
</template>
