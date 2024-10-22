<script setup lang="ts">
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { delay } from "@/Shared/utils";
import Alert from "@/Components/Alert.vue";

defineProps<{
  message?: string;
}>();

const show = ref(false);

const flashMessage = () => {
  // check if flash message is present
  if (!!(usePage().props as any).flash.status) {
    // show alert first
    show.value = true;
    // then set the timeout to auto-dismiss alert
    delay(1000, () => (show.value = false));
  } else {
    // reset visibility
    show.value = false;
  }
};

// TODO: improve this change detection logic:
// usePage props watch not always picking up the changes ?
watch(() => usePage().props, flashMessage);

// do initial flash message check
flashMessage();
</script>

<template>
  <div class="fixed inset-x-0 bottom-0">
    <Transition>
      <Alert
        v-if="show && message"
        class="w-auto md:w-1/3 m-5 md:mx-auto"
        v-bind="{ message }"
      />
    </Transition>
  </div>
</template>
