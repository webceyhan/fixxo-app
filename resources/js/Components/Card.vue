<script setup lang="ts">
defineProps<{
  title?: string;
  flush?: boolean;
}>();
</script>

<template>
  <div
    class="card bg-base-300 divide-y-2 divide-base-100 ring-1 ring-primary/10 overflow-hidden shadow-xl"
  >
    <!-- header -->
    <div v-if="$slots.header || title" class="card-body grow-0">
      <header class="card-title justify-between gap-2">
        <slot name="header">
          {{ title }}
        </slot>
      </header>
    </div>

    <!-- body -->
    <div :class="['card-body', { 'p-0': flush }]">
      <slot />
    </div>

    <!-- footer -->
    <div v-if="$slots.footer" class="card-body grow-0">
      <footer class="card-actions justify-end">
        <slot name="footer" />
      </footer>
    </div>
  </div>
</template>
