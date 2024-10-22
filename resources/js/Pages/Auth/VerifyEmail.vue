<script setup lang="ts">
import { computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Link from "@/Components/Link.vue";
import Form from "@/Components/Form/Form.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps<{
  status?: string;
}>();

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(() => props.status === "verification-link-sent");
</script>

<template>
  <GuestLayout>
    <Head title="Email Verification" />

    <Form @submit="submit">
      <template #description>
        Thanks for signing up! Before getting started, could you verify your email address
        by clicking on the link we just emailed to you? If you didn't receive the email,
        we will gladly send you another.
      </template>

      <div v-if="verificationLinkSent" class="font-medium text-sm text-success">
        A new verification link has been sent to the email address you provided during
        registration.
      </div>

      <template #actions>
        <PrimaryButton type="submit" :disabled="form.processing">
          Resend Verification Email
        </PrimaryButton>

        <Link label="Log Out" :href="route('logout')" method="post" as="button" />
      </template>
    </Form>
  </GuestLayout>
</template>
