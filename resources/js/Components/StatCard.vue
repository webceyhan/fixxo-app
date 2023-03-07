<script setup>
import Card from "./Card.vue";
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  items: { type: Array, default: () => [] },
});
</script>

<template>
  <Card class="border-slate-500 border-l-4 relative">
    <div class="absolute top-2 right-4">
      <Icon
        v-if="icon"
        :name="icon"
        class="text-4xl sm:text-6xl text-gray-500 opacity-25"
      />
    </div>

    <h2
      v-if="label"
      class="font-semibold uppercase text-lg text-gray-400 leading-tight mb-6"
    >
      {{ label }}
    </h2>

    <slot>
      <dl class="grid grid-cols-1 xl:grid-cols-2 gap-y-2 xl:divide-x divide-slate-500">
        <div
          v-for="(item, i) in items"
          :key="i"
          class="flex justify-between items-center xl:items-start xl:flex-col-reverse first:p-0 xl:pl-8"
        >
          <dt class="text-base leading-7 dark:text-gray-400">
            {{ item.label }}
          </dt>
          <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">
            {{ item.value }}
          </dd>
        </div>
      </dl>
    </slot>
  </Card>
</template>
