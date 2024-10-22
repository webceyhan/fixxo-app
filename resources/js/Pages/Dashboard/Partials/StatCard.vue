<script setup lang="ts">
import { computed } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";
import Stat from "@/Components/Stat/Stat.vue";
import StatGroup from "@/Components/Stat/StatGroup.vue";
import StatTitle from "@/Components/Stat/StatTitle.vue";
import StatValue from "@/Components/Stat/StatValue.vue";

const props = defineProps<{
  label: string;
  icon?: string;
  items?: { label: string; value: number }[]; // TODO: extract to shared types
  formatAsMoney?: boolean;
}>();

const normalizedItems = computed(() => {
  return Array.from({ length: 2 }, (_, i) => ({
    label: props.items?.[i]?.label ?? "N/A",
    value: props.items?.[i]?.value ?? 0,
  }));
});
</script>

<template>
  <Card class="border-l-4">
    <h1 class="card-title uppercase">
      {{ label }}
      <Icon v-if="icon" :name="icon" class="ml-auto text-4xl opacity-25" />
    </h1>

    <slot>
      <StatGroup class="-ml-6 bg-transparent">
        <Stat v-for="item in normalizedItems">
          <StatValue :text="formatAsMoney ? formatMoney(item.value) : item.value" />
          <StatTitle :text="item.label.replace('_', ' ')" />
        </Stat>
      </StatGroup>
    </slot>
  </Card>
</template>
