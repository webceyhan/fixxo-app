<script setup>
import { useDarkTheme } from "@/Shared/utils";
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";
import Searchbar from "@/Layouts/Partials/SearchBar.vue";
import UserMenu from "@/Layouts/Partials/UserMenu.vue";
import NotificationMenu from "@/Layouts/Partials/NotificationMenu.vue";

defineEmits(["toggle"]);

const props = defineProps({
  user: Object,
});

const { isDark, toggleDark } = useDarkTheme();
</script>

<template>
  <nav
    class="sticky top-0 border-b-4 border-indigo-500 dark:border-indigo-900 backdrop-blur-md backdrop-brightness-125 shadow-md z-50"
  >
    <div class="container mx-auto flex items-center gap-4 py-3 px-4 sm:px-6 lg:px-8">
      <!-- Hamburger -->
      <button @click="$emit('toggle')" class="text-gray-500 focus:outline-none lg:hidden">
        <Icon class="text-3xl" name="list" />
      </button>

      <!-- SearchBar -->
      <Searchbar class="mr-auto" />

      <!-- Theme Toggle -->
      <button @click="toggleDark()" class="max-md:hidden">
        <Avatar
          :icon="isDark ? 'moon' : 'sun'"
          class="dark:text-white/50 dark:hover:text-white"
        />
      </button>

      <!-- Notification Menu -->
      <NotificationMenu class="hidden sm:inline sm:mx-2" />

      <!-- User Menu -->
      <UserMenu :user="user" class="flex-shrink-0" />
    </div>
  </nav>
</template>
