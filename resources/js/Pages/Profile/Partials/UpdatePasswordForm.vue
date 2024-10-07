<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <Form @submit="updatePassword">
    <template #title> Update Password </template>

    <template #description>
      Ensure your account is using a long, random password to stay secure.
    </template>

    <FormControl
      id="current_password"
      ref="currentPasswordInput"
      label="Current Password"
      type="password"
      autocomplete="current-password"
      v-model="form.current_password"
      :error="form.errors.current_password"
    />

    <FormControl
      id="password"
      ref="passwordInput"
      label="New Password"
      type="password"
      autocomplete="new-password"
      v-model="form.password"
      :error="form.errors.password"
    />

    <FormControl
      id="password_confirmation"
      type="password"
      label="Confirm Password"
      autocomplete="new-password"
      v-model="form.password_confirmation"
      :error="form.errors.password_confirmation"
    />

    <template #actions>
      <PrimaryButton type="submit" label="Save" icon="save" :disabled="form.processing" />

      <Transition
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
        class="transition ease-in-out"
      >
        <p v-if="form.recentlySuccessful" class="text-sm text-success">Saved.</p>
      </Transition>
    </template>
  </Form>
</template>
