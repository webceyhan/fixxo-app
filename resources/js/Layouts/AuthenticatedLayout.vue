<script setup lang="ts">
import { computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Drawer from "@/Components/Drawer.vue";
import Navbar from "@/Components/Navbar.vue";
import NavbarHamburger from "./Partials/NavbarHamburger.vue";
import NavbarSearch from "./Partials/NavbarSearch.vue";
import NavbarThemeController from "./Partials/NavbarThemeController.vue";
import NavbarNotificationMenu from "./Partials/NavbarNotificationMenu.vue";
import NavbarUserMenu from "./Partials/NavbarUserMenu.vue";
import NotificationBar from "./Partials/NotificationBar.vue";
import Breadcrumbs from "./Partials/Breadcrumbs.vue";
import Sidebar from "./Partials/Sidebar.vue";

const props = defineProps<{
  title?: string;
}>();

const currentTitle = computed(
  // TODO: define type
  () => props.title ?? (usePage().props as any).breadcrumbs.at(-1)?.title
);
</script>

<template>
  <Drawer id="app-drawer" responsive>
    <Head :title="currentTitle" />

    <template #aside>
      <!-- Side Navigation -->
      <Sidebar />
    </template>

    <!-- Top Navigation -->
    <Navbar class="sticky top-0 glass shadow-md z-50 py-3 px-4 sm:px-6 lg:px-8">
      <template #start>
        <NavbarHamburger for="app-drawer" class="lg:hidden" />
        <NavbarSearch />
      </template>

      <template #end>
        <NavbarThemeController class="max-md:hidden" />
        <NavbarNotificationMenu class="max-md:hidden" />
        <NavbarUserMenu :user="$page.props.auth.user" />
      </template>
    </Navbar>

    <!-- Page Wrapper -->
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8">
      <!-- Page Heading -->
      <header>
        <!-- // TODO: define type -->
        <Breadcrumbs :links="$page.props.breadcrumbs as any" class="hidden md:flex" />
        <h2 class="text-2xl md:hidden">
          <slot name="title">{{ currentTitle }}</slot>
        </h2>
      </header>

      <!-- Page Content -->
      <main class="space-y-6 lg:space-y-8"><slot /></main>
    </div>

    <!-- Notifications // TODO: define type -->
    <NotificationBar :message="($page.props.flash as any).status" />
  </Drawer>
</template>
