<script setup>
import { MenuButton } from "@headlessui/vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";

defineProps({
  user: Object,
});
</script>

<template>
  <Dropdown flush>
    <template #trigger>
      <MenuButton
        :class="{
          'flex items-center space-x-2 focus:outline-none transition ease-in-out duration-150': true,
          'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300': true,
        }"
      >
        <div class="hidden sm:flex flex-col text-end">
          <span class="text-sm leading-4 font-medium">{{ user?.name }}</span>
          <small class="text-gray-400">{{ user?.role ?? "Expert" }}</small>
        </div>

        <Avatar
          class="!w-14 !h-14"
          src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
        />

        <!-- <Avatar icon="profile" /> -->
      </MenuButton>
    </template>

    <DropdownItem label="Profile" icon="profile" :href="route('profile.edit')" />

    <DropdownItem label="Log Out" icon="logout" method="post" :href="route('logout')" />
  </Dropdown>
</template>
