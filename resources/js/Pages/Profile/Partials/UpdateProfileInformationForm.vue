<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
});
</script>

<template>
  <Form @submit="form.patch(route('profile.update'))">
    <template #title> Profile Information </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <FormControl
      id="name"
      type="text"
      label="Name"
      required
      autofocus
      autocomplete="name"
      v-model="form.name"
      :error="form.errors.name"
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

    <div v-if="mustVerifyEmail && user.email_verified_at === null">
      <p class="text-sm">
        Your email address is unverified.
        <Link
          class="link-primary link-hover"
          :href="route('verification.send')"
          method="post"
          as="button"
        >
          Click here to re-send the verification email.
        </Link>
      </p>

      <div
        v-show="status === 'verification-link-sent'"
        class="mt-2 font-medium text-sm text-success"
      >
        A new verification link has been sent to your email address.
      </div>
    </div>

    <template #actions>
      <PrimaryButton type="submit" label="Save" icon="save" :disabled="form.processing" />

      <Transition
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
        class="transition ease-in-out"
      >
        <p v-if="form.recentlySuccessful" class="text-sm text-success">Saved.</p>
      </Transition>
    </template>
  </Form>
</template>
