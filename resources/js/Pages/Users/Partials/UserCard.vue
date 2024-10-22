<script setup lang="ts">
import Card from "@/Components/Card.vue";
import Field from "@/Components/Field/Field.vue";
import FieldGroup from "@/Components/Field/FieldGroup.vue";
import LinkField from "@/Components/Field/LinkField.vue";
import DateField from "@/Components/Field/DateField.vue";
import UserBadge from "./UserBadge.vue";

defineProps<{
  user: any; // TODO: define User type
}>();
</script>

<template>
  <Card>
    <template #header>
      User

      <UserBadge :status="user.status" />
    </template>

    <FieldGroup>
      <Field label="Name" :value="user.name" />

      <LinkField v-if="user.phone" label="Phone" :value="user.phone" phone />

      <LinkField label="Email" :value="user.email" email />

      <Field label="Role" :value="user.role" class="capitalize" />

      <DateField
        v-if="user.email_verified_at"
        label="Email Verified At"
        :value="user.email_verified_at"
      />

      <DateField label="Created At" :value="user.created_at" />

      <DateField label="Last Update" :value="user.updated_at" />
    </FieldGroup>
  </Card>
</template>
