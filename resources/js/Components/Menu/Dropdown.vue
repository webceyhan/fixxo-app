<script setup lang="ts">
import { onMounted, onUnmounted } from "vue";
import Menu from "./Menu.vue";
import DropdownTrigger from "./DropdownTrigger.vue";

defineProps<{
  label?: string;
  icon?: string;
  primary?: boolean;
  wide?: boolean;
  alignEnd?: boolean;
}>();

const closeOnEscape = (e: KeyboardEvent) => {
  if (e.key === "Escape") {
    (document.activeElement as HTMLElement)?.blur();
  }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));
</script>

<template>
  <div :class="['dropdown', { 'dropdown-end': alignEnd }]">
    <!-- trigger -->
    <slot name="trigger">
      <DropdownTrigger v-bind="{ label, icon, primary }" />
    </slot>

    <Menu
      tabindex="0"
      :class="['dropdown-content p-2 z-20 shadow shadow-neutral', wide ? 'w-80' : 'w-52']"
    >
      <!-- default -->
      <slot />
    </Menu>
  </div>
</template>
