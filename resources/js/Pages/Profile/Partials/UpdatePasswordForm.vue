<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Update Password
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
      <FormControl
        id="current_password"
        ref="currentPasswordInput"
        label="Current Password"
        type="password"
        autocomplete="current-password"
        v-model="form.current_password"
        :error="form.errors.current_password"
      />

      <FormControl
        id="password"
        ref="passwordInput"
        label="New Password"
        type="password"
        class="mt-1 block w-full"
        autocomplete="new-password"
        v-model="form.password"
        :error="form.errors.password"
      />

      <FormControl
        id="password_confirmation"
        type="password"
        label="Confirm Password"
        class="mt-1 block w-full"
        autocomplete="new-password"
        v-model="form.password_confirmation"
        :error="form.errors.password_confirmation"
      />

      <div class="flex items-center gap-4">
        <PrimaryButton label="Save" icon="save" :disabled="form.processing" />

        <Transition
          enter-from-class="opacity-0"
          leave-to-class="opacity-0"
          class="transition ease-in-out"
        >
          <p
            v-if="form.recentlySuccessful"
            class="text-sm text-gray-600 dark:text-gray-400"
          >
            Saved.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
