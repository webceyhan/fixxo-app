<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import Icon from "../Icon.vue";

const props = defineProps({
  label: String,
  align: { default: "right" },
  width: { default: "48" },
  contentClasses: {
    default: () => ["py-1", "bg-white dark:bg-gray-700"],
  },
});

const open = ref(false);

const closeOnEscape = (e) => {
  if (open.value && e.key === "Escape") {
    open.value = false;
  }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

const widthClass = computed(() => {
  return { 48: "w-48" }[props.width.toString()];
});

const alignmentClasses = computed(() => {
  if (props.align === "left") {
    return "origin-top-left left-0";
  } else if (props.align === "right") {
    return "origin-top-right right-0";
  } else {
    return "origin-top";
  }
});
</script>

<template>
  <div class="relative">
    <div @click="open = !open">
      <slot name="trigger">
        <span class="inline-flex rounded-md">
          <button
            type="button"
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
          >
            {{ label }}

            <Icon name="chevron-down" class="text-xs ml-2 -mr-0.5" />
          </button>
        </span>
      </slot>
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="open"
        class="absolute z-50 mt-2 rounded-md shadow-lg"
        :class="[widthClass, alignmentClasses]"
        style="display: none"
        @click="open = false"
      >
        <div
          class="rounded-md ring-1 ring-black dark:ring-gray-500 ring-opacity-5"
          :class="contentClasses"
        >
          <slot />
        </div>
      </div>
    </transition>
  </div>
</template>
