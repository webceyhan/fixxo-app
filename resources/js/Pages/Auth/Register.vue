<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Link from "@/Components/Link.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <Form @submit="submit">
      <FormControl
        id="name"
        type="text"
        label="Name"
        v-model="form.name"
        :error="form.errors.name"
        autocomplete="name"
        required
        autofocus
      />

      <FormControl
        id="email"
        type="email"
        label="Email"
        v-model="form.email"
        :error="form.errors.email"
        autocomplete="username"
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
        <Link class="ml-auto" label="Already registered?" :href="route('login')" small />

        <PrimaryButton type="submit" label="Register" :disabled="form.processing" />
      </template>
    </Form>
  </GuestLayout>
</template>
