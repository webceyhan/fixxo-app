<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

defineProps<{
  status?: string;
}>();

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

    <Form @submit="submit">
      <template #description>
        Forgot your password? No problem. Just let us know your email address and we will
        email you a password reset link that will allow you to choose a new one.
      </template>

      <div v-if="status" class="mb-4 font-medium text-sm text-success" v-html="status" />

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

      <template #actions>
        <PrimaryButton class="ml-auto" type="submit" :disabled="form.processing">
          Email Password Reset Link
        </PrimaryButton>
      </template>
    </Form>
  </GuestLayout>
</template>
