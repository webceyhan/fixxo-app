<script setup lang="ts">
import { onMounted, onUnmounted } from "vue";
import Icon from "@/Components/Icon.vue";

const open = defineModel("open", { default: false });

defineProps<{
  size?: string; // TODO: define Size type
}>();

const close = () => {
  open.value = false;
};

const closeOnEscape = (e: KeyboardEvent) => {
  e.key === "Escape" && close();
};

onMounted(() => {
  document.addEventListener("keydown", closeOnEscape);
});

onUnmounted(() => {
  document.removeEventListener("keydown", closeOnEscape);
});
</script>

<template>
  <Teleport to="body">
    <dialog class="modal max-sm:modal-bottom" :open>
      <div
        :class="[
          'modal-box shadow-lg shadow-base-content/50',
          {
            'w-2/3 max-w-4xl': size === 'xl',
          },
        ]"
      >
        <!-- close button -->
        <form method="dialog">
          <button
            class="btn btn-ghost btn-sm btn-circle absolute right-2 top-2"
            @click="close"
          >
            <Icon name="x-lg" />
          </button>
        </form>

        <section class="w-full space-y-4">
          <!-- title -->
          <h2 v-if="$slots.title" class="text-lg font-medium">
            <slot name="title" />
          </h2>

          <!-- content -->
          <slot :close />

          <!-- actions -->
          <div v-if="$slots.actions" class="modal-action gap-2 pt-4">
            <slot name="actions" />
          </div>
        </section>
      </div>

      <!-- backdrop -->
      <form method="dialog" class="modal-backdrop">
        <button class="cursor-default" @click="close" />
      </form>
    </dialog>
  </Teleport>
</template>
