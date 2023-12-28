<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

defineProps({
  status: String,
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>

<template>
  <GuestLayout>
    <Head title="Forgot Password" />

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      Forgot your password? No problem. Just let us know your email address and we will
      email you a password reset link that will allow you to choose a new one.
    </div>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
    >
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <FormControl
        id="email"
        type="email"
        label="Email"
        v-model="form.email"
        :error="form.errors.email"
        autocomplete="username"
        required
        autofocus
      />

      <div class="flex items-center justify-end">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Email Password Reset Link
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
