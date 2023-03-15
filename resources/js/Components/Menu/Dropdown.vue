<script setup>
import { Menu, MenuButton, MenuItems } from "@headlessui/vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Icon from "@/Components/Icon.vue";
import PrimaryButton from "../Button/PrimaryButton.vue";

defineProps({
  label: String,
  icon: String,
  theme: { type: String, default: "secondary" },
  left: Boolean,
  primary: Boolean,
});
</script>

<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <!-- normal button with label -->
      <MenuButton v-if="label" :as="primary ? PrimaryButton : SecondaryButton">
        <Icon v-if="icon" :name="icon" />
        {{ label }}

        <Icon name="chevron-down" class="-mr-1 opacity-50" aria-hidden="true" />
      </MenuButton>

      <!-- menu icon button -->
      <MenuButton v-else>
        <slot name="trigger">
          <Icon
            :name="icon ?? 'three-dots-vertical'"
            class="text-white p-2 hover:bg-gray-800 rounded"
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
        class="z-50 absolute mt-2 w-56 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black dark:ring-gray-500 ring-opacity-5 focus:outline-none"
        :class="{
          'right-0 origin-top-right': !left,
          'left-0 origin-top-left': left,
        }"
      >
        <slot />
      </MenuItems>
    </transition>
  </Menu>
</template>
