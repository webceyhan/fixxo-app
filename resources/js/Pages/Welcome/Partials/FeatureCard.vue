<script setup lang="ts">
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";

defineProps<{
  href?: string;
}>();
</script>

<template>
  <Card :class="{ 'transition duration-300 hover:ring-primary/25': href }">
    <component :is="href ? 'a' : 'div'" :href class="flex flex-col h-full gap-6">
      <!-- slot -->
      <slot name="top" />

      <div class="flex items-start gap-4 sm:gap-6">
        <!-- avatar -->
        <div class="avatar placeholder">
          <div class="bg-accent/10 text-accent sm:text-2xl rounded-full p-4 sm:p-5">
            <slot name="avatar" />
          </div>
        </div>

        <div class="pt-3 sm:pt-4">
          <!-- title -->
          <h2 class="text-xl font-semibold">
            <slot name="title" />
          </h2>

          <!-- default -->
          <p class="mt-4 text-sm/relaxed text-base-content/70">
            <slot />
          </p>
        </div>

        <Icon
          v-if="href"
          name="arrow-right"
          class="text-xl shrink-0 self-center text-accent"
        />
      </div>
    </component>
  </Card>
</template>
