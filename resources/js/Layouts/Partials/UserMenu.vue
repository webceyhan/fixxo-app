<script setup>
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";

defineProps({
  user: Object,
});
</script>

<template>
  <Dropdown align-end>
    <template #trigger>
      <button class="inline-flex items-center gap-3">
        <div class="hidden sm:block text-end">
          <p class="leading-5 font-medium">{{ user?.name }}</p>
          <p class="text-sm text-gray-500">{{ user?.role ?? "Technician" }}</p>
        </div>

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
