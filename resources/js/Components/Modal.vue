<script setup>
import { ref } from "vue";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionRoot,
  TransitionChild,
} from "@headlessui/vue";
import SecondaryButton from "./Button/SecondaryButton.vue";

const emit = defineEmits(["open", "close"]);

const props = defineProps({
  show: Boolean,
  cancellable: Boolean,
});

const isShown = ref(props.show);

function close() {
  isShown.value = false;
  emit("close");
}

function open() {
  isShown.value = true;
  emit("open");
}

defineExpose({
  open,
  close,
});
</script>

<template>
  <TransitionRoot appear :show="isShown" as="template">
    <Dialog as="div" @close="close" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left align-middle shadow-xl transition-all p-6 space-y-6"
            >
              <!-- title -->
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100"
              >
                <slot name="title" />
              </DialogTitle>

              <!-- content -->
              <slot />

              <!-- modal actions -->
              <div class="flex justify-start items-center gap-4">
                <SecondaryButton
                  v-if="cancellable"
                  label="Cancel"
                  icon="dismiss"
                  @click="close"
                />
                <slot name="actions" />
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
