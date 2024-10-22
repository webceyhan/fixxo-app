<script setup>
import Icon from "../Icon.vue";

const props = defineProps({
  time: String,
  icon: String,
});
</script>

<template>
  <li>
    <hr class="bg-neutral" />

    <!-- figure -->
    <div class="timeline-middle">
      <slot name="figure">
        <Icon :name="icon??'check-circle'" class="text-xl" />
      </slot>
    </div>

    <div class="timeline-end ml-3 mt-[8px] mb-6">
      <!-- time -->
      <time v-if="time" class="text-sm font-mono italic" v-html="time" />

      <!-- default -->
      <slot />
    </div>

    <hr class="bg-neutral" />
  </li>
</template>
