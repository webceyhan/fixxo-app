<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import SignaturePad from "signature_pad";
import Modal from "@/Components/Modal.vue";
import RadioGroup from "@/Components/Form/RadioGroup.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const props = defineProps<{
  ticket: any; // TODO: define Ticket type
}>();

const isOpen = ref(false);
const canvas = ref<HTMLCanvasElement | null>(null);
const pad = ref<SignaturePad | null>(null);

// TODO: extract to shared file
const typeOptions = ["intake", "delivery"];

const form = useForm({
  type: typeOptions[0],
  blob: "",
});

const save = () => {
  // append signature blob to form
  form.blob = pad.value?.toDataURL("image/svg+xml")!;

  // submit form
  form.post(route("tickets.sign", props.ticket.id), {
    preserveScroll: true,
    onSuccess: () => (isOpen.value = false),
  });
};

const clear = () => pad.value?.clear();

const resize = () => {
  // Important! we need to set the canvas to display: block
  // on order to get the correct offsetWidth and offsetHeight
  const { offsetWidth, offsetHeight } = canvas.value!;

  // skip if canvas is not visible
  if (offsetWidth === 0) return;

  // Set display size (css pixels).
  canvas.value!.style.width = `${offsetWidth}px`;
  canvas.value!.style.height = `${offsetHeight}px`;

  // Set actual size in memory (scaled to account for extra pixel density).
  const scale = window.devicePixelRatio; // Change to 1 on retina screens to see blurry canvas.
  canvas.value!.width = Math.floor(offsetWidth * scale);
  canvas.value!.height = Math.floor(offsetHeight * scale);

  // Normalize coordinate system to use CSS pixels.
  canvas.value!.getContext("2d")?.scale(scale, scale);

  // This library does not listen for canvas changes, so after the canvas is automatically
  // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
  // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
  // that the state of this library is consistent with visual state of the canvas, you
  // have to clear it manually.
  clear();
};

watch(
  () => isOpen.value,
  // bugfix: offset is 0 when modal is not visible
  // we need to wait for the modal to be visible
  (open) => open && setTimeout(resize, 10)
);

onMounted(() => {
  // initialize the signature pad
  pad.value = new SignaturePad(canvas.value!);
});

defineExpose({
  open: () => (isOpen.value = true),
  close: () => (isOpen.value = false),
});
</script>

<template>
  <Modal v-model:open="isOpen">
    <template #title> Sign for {{ form.type }} </template>

    <canvas
      ref="canvas"
      class="block w-full h-auto min-h-max bg-white"
      width="600"
      height="300"
    />

    <template #actions>
      <RadioGroup v-model="form.type" :options="typeOptions" class="mr-auto" />
      <DangerButton label="Clear" @click="clear" />
      <PrimaryButton label="Save" @click="save" />
    </template>
  </Modal>
</template>
