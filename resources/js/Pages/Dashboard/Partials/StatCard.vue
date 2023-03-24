<script setup>
import { computed } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
  label: String,
  icon: String,
  items: Array,
  formatAsMoney: Boolean,
});

const normalizedItems = computed(() => {
  return Array.from({ length: 2 }, (_, i) => ({
    label: props.items[i]?.label ?? "N/A",
    value: props.items[i]?.value ?? 0,
  }));
});
</script>

<template>
  <Card class="border-slate-500 border-l-4">
    <header
      class="flex justify-between items-center font-semibold uppercase text-lg text-gray-400 leading-tight mb-4"
    >
      <span>{{ label }}</span>
      <Icon v-if="icon" :name="icon" class="text-4xl opacity-25" />
    </header>

    <slot>
      <dl class="grid grid-cols-1 xl:grid-cols-2 gap-y-2 xl:divide-x divide-slate-500">
        <div
          v-for="(item, i) in normalizedItems"
          :key="i"
          class="flex justify-between items-center xl:items-start xl:flex-col-reverse first:p-0 xl:pl-8"
        >
          <dt class="text-base leading-7 dark:text-gray-400">
            {{ item.label }}
          </dt>
          <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">
            {{ formatAsMoney ? formatMoney(item.value) : item.value }}
          </dd>
        </div>
      </dl>
    </slot>
  </Card>
</template>
