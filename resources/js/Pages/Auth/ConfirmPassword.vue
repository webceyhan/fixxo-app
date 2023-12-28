<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

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

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      This is a secure area of the application. Please confirm your password before
      continuing.
    </div>

    <form @submit.prevent="submit" class="space-y-6">
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

      <div class="flex justify-end">
        <PrimaryButton
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Confirm
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
