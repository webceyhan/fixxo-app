<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps<{
  email: string;
  token: string;
}>();

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

    <Form @submit="submit">
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

      <template #actions>
        <PrimaryButton class="ml-auto" type="submit" :disabled="form.processing">
          Reset Password
        </PrimaryButton>
      </template>
    </Form>
  </GuestLayout>
</template>
