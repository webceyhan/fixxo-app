<script setup>
import { ref, onMounted, watch } from "vue";
import { Dialog, DialogPanel, DialogTitle } from "@headlessui/vue";
import SignaturePad from "signature_pad";
import RadioGroup from "@/Components/Form/RadioGroup.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

defineProps({
  //
});

const typeOptions = ["intake", "delivery"];
const type = ref(typeOptions[0]);

const isOpen = ref(false);
const canvas = ref(null);
const pad = ref(null);

const setIsOpen = (value) => (isOpen.value = value);

watch(
  () => isOpen.value,
  // bugfix: offset is 0 when modal is not visible
  // we need to wait for the modal to be visible
  (open) => open && setTimeout(resize, 10)
);

onMounted(() => {
  // initialize the signature pad
  pad.value = new SignaturePad(canvas.value);
});

const clear = () => pad.value.clear();

const resize = () => {
  // Important! we need to set the canvas to display: block
  // on order to get the correct offsetWidth and offsetHeight
  const { offsetWidth, offsetHeight } = canvas.value;

  // skip if canvas is not visible
  if (offsetWidth === 0) return;

  // Set display size (css pixels).
  canvas.value.style.width = `${offsetWidth}px`;
  canvas.value.style.height = `${offsetHeight}px`;

  // Set actual size in memory (scaled to account for extra pixel density).
  const scale = window.devicePixelRatio; // Change to 1 on retina screens to see blurry canvas.
  canvas.value.width = Math.floor(offsetWidth * scale);
  canvas.value.height = Math.floor(offsetHeight * scale);

  // Normalize coordinate system to use CSS pixels.
  canvas.value.getContext("2d").scale(scale, scale);

  // This library does not listen for canvas changes, so after the canvas is automatically
  // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
  // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
  // that the state of this library is consistent with visual state of the canvas, you
  // have to clear it manually.
  clear();
};

defineExpose({
  open: () => setIsOpen(true),
  close: () => setIsOpen(false),
});
</script>

<template>
  <Dialog :open="isOpen" @close="setIsOpen" class="relative z-50" :unmount="false">
    <!-- The backdrop, rendered as a fixed sibling to the panel container -->
    <div class="fixed inset-0 bg-black/30" aria-hidden="true" />

    <!-- Full-screen container to center the panel -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
      <DialogPanel
        class="w-full sm:max-w-2xl transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 shadow-xl dark:shadow-gray-700 transition-all p-6 space-y-6"
      >
        <DialogTitle
          class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100"
        >
          Sign for {{ type }}
        </DialogTitle>

        <canvas
          ref="canvas"
          class="block w-full h-auto min-h-max bg-white"
          width="600"
          height="300"
        />

        <div class="flex justify-between items-center gap-2">
          <PrimaryButton label="Save" />
          <DangerButton label="Clear" class="mr-auto" @click="clear()" />
          <!-- <SecondaryButton label="Cancel" class="mr-auto" @click="setIsOpen(false)" /> -->
          <RadioGroup v-model="type" :options="typeOptions" />
        </div>
      </DialogPanel>
    </div>
  </Dialog>
</template>
