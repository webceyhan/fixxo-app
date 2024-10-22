<script setup>
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const emit = defineEmits(["submit", "dismiss"]);

const props = defineProps({
  form: Object,
  resource: String,
  deletable: Boolean,
  dismissable: Boolean,
  noActions: Boolean,
});

const submit = () => {
  props.resource ? save() : emit("submit");
};

const save = () => {
  const isUpdate = !!props.form?.id;
  const method = isUpdate ? "put" : "post";

  const url = isUpdate
    ? route(`${props.resource}.update`, props.form.id)
    : route(`${props.resource}.store`);

  props.form.submit(method, url, {
    preserveScroll: true,
    onSuccess: () => emit("dismiss"),
  });
};

const cancel = () => {
  if (props.dismissable) {
    return emit("dismiss");
  }

  window.history.back();
};

defineExpose({ save, cancel });
</script>

<template>
  <form class="space-y-6" @submit.prevent="submit" novalidate>
    <!-- header -->
    <header v-if="$slots.title || $slots.description" class="space-y-2">
      <!-- title -->
      <h2 v-if="$slots.title" class="text-lg font-medium">
        <slot name="title" />
      </h2>

      <!-- description -->
      <p v-if="$slots.description" class="text-sm text-base-content/60">
        <slot name="description" />
      </p>
    </header>

    <!-- default -->
    <slot />

    <!-- actions -->
    <div v-if="!noActions" class="flex items-center justify-between gap-4">
      <slot name="actions">
        <PrimaryButton label="Save" icon="save" type="submit" />

        <SecondaryButton label="Cancel" icon="dismiss" @click="cancel" class="mr-auto" />

        <DangerButton
          v-if="deletable && form?.id"
          label="Delete"
          icon="delete"
          method="delete"
          @click="$emit('dismiss')"
          :href="route(`${resource}.destroy`, form.id)"
          preserve-scroll
        />
      </slot>
    </div>
  </form>
</template>
