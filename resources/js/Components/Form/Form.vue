<script setup>
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const emit = defineEmits(["dismiss"]);

const props = defineProps({
  form: Object,
  resource: String,
  deletable: Boolean,
  dismissable: Boolean,
});

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
</script>

<template>
  <form @submit.prevent="save" novalidate class="space-y-6">
    <slot />

    <slot name="actions">
      <div class="flex justify-between gap-4">
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
      </div>
    </slot>
  </form>
</template>
