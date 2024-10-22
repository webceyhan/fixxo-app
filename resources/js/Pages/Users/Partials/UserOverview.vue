<script setup>
import { formatDate } from "@/Shared/utils";
import Overview from "@/Components/Overview.vue";
import OverviewField from "@/Components/OverviewField.vue";
import UserBadge from "./UserBadge.vue";

/**
 * This is just a demo component which is not used yet.
 * We keep it as a reference for the Overview component.
 */
defineProps({
  user: Object,
});
</script>

<template>
  <Overview>
    <template #title> User Information </template>

    <template #subtitle> Personal details and application. </template>

    <OverviewField label="Full name" :value="user.name" />

    <OverviewField label="Email address" :value="user.email" />

    <OverviewField label="Role" :value="user.role" />

    <OverviewField label="Status">
      <UserBadge :status="user.status" />
    </OverviewField>

    <OverviewField label="Created at" :value="formatDate(user.created_at, false)" />

    <OverviewField label="Updated at" :value="formatDate(user.updated_at, false)" />

    <OverviewField
      label="Email verified date"
      :value="formatDate(user.email_verified_at, false)"
    />
  </Overview>
</template>
