<script setup>
import { MenuButton } from "@headlessui/vue";
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";

defineEmits(["toggle"]);

const props = defineProps({
  user: Object,
});
</script>

<template>
  <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- left side placeholder -->
        <div class="shrink-0 flex items-center">
          <!-- something comes here later.. -->
        </div>

        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <Dropdown>
              <template #trigger>
                <MenuButton
                  class="flex items-center space-x-2 border-0 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                >
                  <p class="text-sm leading-4 font-medium">
                    {{ user.name }}
                  </p>

                  <Avatar icon="profile" />
                </MenuButton>
              </template>

              <DropdownItem
                label="Profile"
                icon="profile"
                :href="route('profile.edit')"
              />

              <DropdownItem
                label="Log Out"
                icon="logout"
                method="post"
                :href="route('logout')"
              />
            </Dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="flex items-center sm:hidden">
          <button
            @click="$emit('toggle')"
            class="inline-flex items-center justify-center py-1 px-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
          >
            <Icon name="list" class="text-3xl" />
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>
