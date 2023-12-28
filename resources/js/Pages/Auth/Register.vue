<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Link from "@/Components/Link.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

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

    <form @submit.prevent="submit" class="space-y-6">
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

      <div class="flex items-center justify-end space-x-4">
        <Link label="Already registered?" :href="route('login')" small />

        <PrimaryButton label="Register" :disabled="form.processing" />
      </div>
    </form>
  </GuestLayout>
</template>
