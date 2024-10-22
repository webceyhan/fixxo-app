<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Link from "@/Components/Link.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

defineProps<{
  canResetPassword: boolean;
  status?: string;
}>();

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

    <Form @submit="submit">
      <div v-if="status" class="mb-4 font-medium text-sm text-success" v-html="status" />

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

      <template #actions>
        <Link
          v-if="canResetPassword"
          class="ml-auto"
          label="Forgot your password?"
          :href="route('password.request')"
          small
        />

        <PrimaryButton type="submit" label="Log in" :disabled="form.processing" />
      </template>
    </Form>
  </GuestLayout>
</template>
