<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  email: String,
  token: String,
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <form @submit.prevent="submit" class="space-y-6">
      <FormControl
        id="email"
        type="email"
        label="Email"
        v-model="form.email"
        :error="form.errors.email"
        autocomplete="username"
        autofocus
        required
      />

      <FormControl
        id="password"
        type="password"
        label="Password"
        v-model="form.password"
        :error="form.errors.password"
        autocomplete="new-password"
        required
      />

      <FormControl
        id="password_confirmation"
        type="password"
        label="Confirm Password"
        v-model="form.password_confirmation"
        :error="form.errors.password_confirmation"
        autocomplete="new-password"
        required
      />

      <div class="flex items-center justify-end">
        <PrimaryButton type="submit" :disabled="form.processing">
          Reset Password
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
