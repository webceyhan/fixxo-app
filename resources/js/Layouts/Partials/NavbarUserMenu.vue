<script setup>
import Avatar from "@/Components/Avatar.vue";
import Field from "@/Components/Field/Field.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";

defineProps({
  user: Object,
});
</script>

<template>
  <Dropdown align-end>
    <template #trigger>
      <button class="btn btn-ghost h-auto pe-0 rounded-badge">
        <Field
          class="max-md:hidden text-end"
          :value="user.name"
          :description="user.role"
        />

        <Avatar
          class="ring-2"
          src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
        />
      </button>
    </template>

    <MenuLink label="Profile" icon="profile" :href="route('profile.edit')" />

    <MenuLink
      class="sm:hidden"
      label="Notifications"
      icon="bell"
      :href="route('profile.edit')"
    />

    <MenuLink label="Log Out" icon="logout" method="post" :href="route('logout')" />
  </Dropdown>
</template>
