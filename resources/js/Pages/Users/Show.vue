<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import UserCard from "./Partials/UserCard.vue";
import AssetList from "../Assets/Partials/AssetList.vue";
import Card from "@/Components/Card.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";

const props = defineProps({
  user: Object,
  recentAssets: Array,
});
</script>

<template>
  <PageLayout :title="user.name">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton label="Edit" icon="edit" :href="route('users.edit', user.id)" />
      <DangerButton
        label="Delete"
        icon="delete"
        method="delete"
        :href="route('users.destroy', user.id)"
        class="mr-4"
      />
      <ToggleButton
        name="status"
        :value="user.status"
        :href="route('users.update', user.id)"
        :options="{
          active: 'Unlock',
          inactive: 'Lock',
        }"
        :icons="{
          active: 'unlock',
          inactive: 'lock',
        }"
        method="put"
        class="mr-4"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem label="Edit" icon="edit" :href="route('users.edit', user.id)" />
        <DropdownItem
          label="Delete"
          icon="delete"
          method="delete"
          :href="route('users.destroy', user.id)"
        />
      </Dropdown>
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
