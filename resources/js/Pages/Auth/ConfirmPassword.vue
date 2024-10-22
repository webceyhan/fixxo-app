<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Confirm Password" />

    <Form @submit="submit">
      <template #description>
        This is a secure area of the application. Please confirm your password before
        continuing.
      </template>

      <FormControl
        id="password"
        type="password"
        label="Password"
        v-model="form.password"
        :error="form.errors.password"
        autocomplete="current-password"
        autofocus
        required
      />

      <template #actions>
        <PrimaryButton type="submit" :disabled="form.processing"> Confirm </PrimaryButton>
      </template>
    </Form>
  </GuestLayout>
</template>
