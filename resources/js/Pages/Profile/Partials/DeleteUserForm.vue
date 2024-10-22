<script setup lang="ts">
import { ComponentPublicInstance, nextTick, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const passwordInput = ref<ComponentPublicInstance<typeof FormControl> | null>(null);
const modalOpen = ref(false);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  modalOpen.value = true;

  nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
  form.delete(route("profile.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value?.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  modalOpen.value = false;
  form.reset();
};
</script>

<template>
  <Form no-actions>
    <template #title>Delete Account</template>

    <template #description>
      Once your account is deleted, all of its resources and data will be permanently
      deleted. Before deleting your account, please download any data or information that
      you wish to retain.
    </template>

    <DangerButton @click="confirmUserDeletion" label="Delete Account" icon="delete" />

    <Modal v-model:open="modalOpen">
      <template #title> Are you sure you want to delete your account? </template>

      <p class="text-sm">
        Once your account is deleted, all of its resources and data will be permanently
        deleted. Please enter your password to confirm you would like to permanently
        delete your account.
      </p>

      <FormControl
        type="password"
        ref="passwordInput"
        label="Password"
        placeholder="Password"
        v-model="form.password"
        :error="form.errors.password"
        @keyup.enter="deleteUser"
      />

      <template #actions>
        <DangerButton
          label="Delete Account"
          icon="delete"
          :disabled="form.processing"
          @click="deleteUser"
        />
      </template>
    </Modal>
  </Form>
</template>
