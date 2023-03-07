<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import UserCard from "./Partials/UserCard.vue";
import AssetList from "../Assets/Partials/AssetList.vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
  user: Object,
  recentAssets: Array,
});
</script>

<template>
  <PageLayout :title="user.name">
    <template #toolbar>
      <SecondaryButton label="Edit" :href="route('users.edit', user.id)" />
      <DangerButton
        label="Delete"
        method="delete"
        :href="route('users.destroy', user.id)"
      />
    </template>

    <template #aside>
      <UserCard :user="user" />
    </template>

    <template #content>
      <Card label="Recent assets.." flush>
        <AssetList :assets="recentAssets" />
      </Card>
    </template>
  </PageLayout>
</template>
