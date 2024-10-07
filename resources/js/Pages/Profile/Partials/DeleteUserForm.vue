<script setup>
import { nextTick, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const confirmationModal = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  confirmationModal.value.open();

  nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
  form.delete(route("profile.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmationModal.value.close();

  form.reset();
};
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Account</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Once your account is deleted, all of its resources and data will be permanently
        deleted. Before deleting your account, please download any data or information
        that you wish to retain.
      </p>
    </header>

    <DangerButton @click="confirmUserDeletion" label="Delete Account" icon="delete" />

    <Modal ref="confirmationModal" cancellable>
      <template #title> Are you sure you want to delete your account? </template>

      <p class="text-sm text-gray-600 dark:text-gray-400">
        Once your account is deleted, all of its resources and data will be permanently
        deleted. Please enter your password to confirm you would like to permanently
        delete your account.
      </p>

      <FormControl
        id="password"
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
  </section>
</template>
