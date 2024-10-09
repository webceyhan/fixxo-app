<script setup>
import { onMounted, onUnmounted } from "vue";
import Menu from "./Menu.vue";
import DropdownTrigger from "./DropdownTrigger.vue";

defineProps({
  label: String,
  icon: String,
  primary: Boolean,
  wide: Boolean,
  alignEnd: Boolean,
});

const closeOnEscape = (e) => {
  if (e.key === "Escape") {
    document.activeElement?.blur();
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
      :class="[
        'dropdown-content p-2 z-20 shadow shadow-neutral',
        wide ? 'w-80' : 'w-52',
      ]"
    >
      <!-- default -->
      <slot />
    </Menu>
  </div>
</template>
