<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";

defineProps({
  label: String,
  icon: String,
  clickable: Boolean,
});
</script>

<template>
  <component
    :is="$attrs.href ? Link : 'li'"
    :class="[
      'group relative card-body flex-row grow-0 justify-between items-center gap-6',
      {
        'hover:bg-base-200': clickable || $attrs.href,
      },
    ]"
  >
    <!-- avatar -->
    <slot name="avatar">
      <Avatar v-if="icon" :icon="icon" class="flex-shrink-0" />
    </slot>

    <slot> {{ label }} </slot>

    <!-- badge -->
    <!-- badge will be visible on the left corner of list icon on mobile
    and moved to the right end of the list item on larger screens -->
    <div
      v-if="$slots.badge"
      class="absolute left-8 bottom-6 xl:relative xl:bottom-0 xl:w-2/12 text-center"
    >
      <slot name="badge" />
    </div>

    <!-- timestamp -->
    <slot name="timestamp" />

    <!-- browse icon -->
    <Icon
      v-if="clickable || $attrs.href"
      name="chevron-right"
      class="text-sm opacity-25 order-last"
    />

    <!-- overlay menu -->
    <div
      v-if="$slots.menu"
      class="absolute inset-y-0 right-0 backdrop-blur-sm flex items-center justify-end px-6 gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-100"
    >
      <slot name="menu" />
    </div>
  </component>
</template>
