<script setup>
import { Menu, MenuButton, MenuItems } from "@headlessui/vue";
import Icon from "@/Components/Icon.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

defineProps({
  label: String,
  icon: String,
  triggerClass: String,
  theme: { type: String, default: "secondary" },
  left: Boolean,
  primary: Boolean,
  wide: Boolean,
});
</script>

<template>
  <Menu as="div" class="relative inline-block text-left">
    <div class="flex h-full">
      <!-- normal button with label -->
      <MenuButton v-if="label" :as="primary ? PrimaryButton : SecondaryButton">
        <Icon v-if="icon" :name="icon" />
        {{ label }}

        <Icon name="chevron-down" class="-mr-1 opacity-50" aria-hidden="true" />
      </MenuButton>

      <!-- menu icon button -->
      <MenuButton v-else :class="triggerClass">
        <slot name="trigger">
          <Icon
            :name="icon ?? 'three-dots-vertical'"
            class="dark:text-gray-300 p-2 hover:bg-gray-800 rounded"
          />
        </slot>
      </MenuButton>
    </div>

    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="z-50 absolute mt-2 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-300 dark:ring-gray-700 focus:outline-none overflow-hidden"
        :class="{
          'right-0 origin-top-right': !left,
          'left-0 origin-top-left': left,
          'w-80': wide,
          'w-56': !wide,
        }"
      >
        <slot />
      </MenuItems>
    </transition>
  </Menu>
</template>
