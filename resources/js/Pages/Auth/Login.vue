<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Link from "@/Components/Link.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <FormControl
        id="email"
        type="email"
        label="Email"
        autocomplete="username"
        v-model="form.email"
        :error="form.errors.email"
        required
        autofocus
      />

      <FormControl
        id="password"
        type="password"
        label="Password"
        autocomplete="current-password"
        v-model="form.password"
        :error="form.errors.password"
        required
      />

      <FormControl
        name="remember"
        label="Remember me"
        type="checkbox"
        v-model="form.remember"
      />

      <div class="flex items-center justify-end space-x-4">
        <Link
          v-if="canResetPassword"
          label="Forgot your password?"
          :href="route('password.request')"
          small
        />

        <PrimaryButton label="Log in" :disabled="form.processing" />
      </div>
    </form>
  </GuestLayout>
</template>
