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
  <div class="flex h-screen">
    <Head :title="currentTitle" />

    <!-- Side Navigation -->
    <Sidebar v-model:toggled="sidebarOpen" />

    <div class="flex-1 overflow-x-hidden overflow-y-auto">
      <!-- Top Navigation -->
      <NavBar :user="$page.props.auth.user" @toggle="sidebarOpen = true" />

      <!-- Page Wrapper -->
      <div class="container mx-auto p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8">
        <!-- Page Heading -->
        <header>
          <Breadcrumbs :links="$page.props.breadcrumbs" class="hidden md:flex" />
          <h2 class="text-2xl dark:text-white md:hidden">
            <slot name="title">{{ currentTitle }}</slot>
          </h2>
        </header>

        <!-- Page Content -->
        <main class="space-y-6 lg:space-y-8"><slot /></main>
      </div>

      <!-- Notifications -->
      <NotificationBar :message="$page.props.flash.status" />
    </div>
  </div>
</template>
