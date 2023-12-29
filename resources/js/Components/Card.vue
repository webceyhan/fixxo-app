<script setup>
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  flush: Boolean,
});
</script>

<template>
  <div class="card bg-base-300 divide-y-2 divide-base-100 overflow-hidden shadow-xl">
    <!-- header -->
    <div v-if="$slots.header || label" class="card-body grow-0">
      <header class="card-title justify-between gap-2">
        <slot name="header">
          <Icon v-if="icon" :name="icon" />
          <h5 class="w-full mr-auto">{{ label }}</h5>
        </slot>

        <slot name="header-action" />
      </header>
    </div>

    <!-- body -->
    <div :class="['card-body', { 'p-0': flush }]">
      <slot />
    </div>

    <!-- footer -->
    <div v-if="$slots.footer" class="card-body grow-0">
      <footer class="flex justify-end">
        <slot name="footer" />
      </footer>
    </div>
  </div>
</template>
