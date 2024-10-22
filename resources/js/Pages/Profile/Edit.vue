<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from "@/Components/Card.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";

defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});
</script>

<template>
  <AuthenticatedLayout title="Profile">
    <Card>
      <UpdateProfileInformationForm
        class="max-w-xl"
        :must-verify-email="mustVerifyEmail"
        :status="status"
      />
    </Card>

    <Card>
      <UpdatePasswordForm class="max-w-xl" />
    </Card>

    <Card>
      <DeleteUserForm class="max-w-xl" />
    </Card>
  </AuthenticatedLayout>
</template>
