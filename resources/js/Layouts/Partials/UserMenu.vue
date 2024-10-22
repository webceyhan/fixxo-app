<script setup>
import { MenuButton } from "@headlessui/vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";

defineProps({
  user: Object,
  right: Boolean,
});
</script>

<template>
  <Dropdown>
    <template #trigger>
      <MenuButton
        :class="{
          'flex items-center gap-3 focus:outline-none transition ease-in-out duration-150': true,
          'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300': true,
        }"
      >
        <div class="hidden sm:block" :class="right ? 'text-start order-2' : 'text-end'">
          <p class="leading-5 font-medium">{{ user?.name }}</p>
          <p class="text-sm text-gray-500">{{ user?.role ?? "Technician" }}</p>
        </div>

        <Avatar
          class="ring-4 ring-gray-200 dark:ring-gray-900"
          src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
        />
      </MenuButton>
    </template>

    <DropdownItem label="Profile" icon="profile" :href="route('profile.edit')" />

    <DropdownItem
      class="sm:hidden"
      label="Notifications"
      icon="bell"
      :href="route('profile.edit')"
    />

    <DropdownItem label="Log Out" icon="logout" method="post" :href="route('logout')" />
  </Dropdown>
</template>
