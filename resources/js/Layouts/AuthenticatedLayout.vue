<script setup>
import { computed, ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import NavBar from "@/Layouts/Partials/NavBar.vue";
import Breadcrumbs from "@/Layouts/Partials/Breadcrumbs.vue";
import NotificationBar from "@/Layouts/Partials/NotificationBar.vue";

const props = defineProps({
  title: String,
});

const sidebarOpen = ref(false);

const currentTitle = computed(
  () => props.title ?? usePage().props.breadcrumbs.at(-1)?.title
);
</script>

<template>
  <div class="flex h-screen bg-gray-200 dark:bg-gray-900">
    <Head :title="currentTitle" />

    <!-- Side Navigation Menu -->
    <Sidebar v-model:toggled="sidebarOpen" />

    <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto">
      <!-- Primary Navigation -->
      <NavBar :user="$page.props.auth.user" @toggle="sidebarOpen = true" />

      <!-- Page Heading -->
      <header class="container mx-auto p-4 sm:p-6 pb-0 sm:pb-0">
        <Breadcrumbs :links="$page.props.breadcrumbs" class="hidden md:flex" />
        <h2 class="text-2xl dark:text-white md:hidden">{{ currentTitle }}</h2>
      </header>

      <!-- Page Content -->
      <main class="container mx-auto p-4 sm:p-6 space-y-6">
        <slot />
      </main>

      <!-- notifications -->
      <NotificationBar :message="$page.props.flash.status" />
    </div>
  </div>
</template>
