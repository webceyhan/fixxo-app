<script setup>
import { computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import NavBar from "@/Layouts/Partials/NavBar.vue";
import Breadcrumbs from "@/Layouts/Partials/Breadcrumbs.vue";
import NotificationBar from "@/Layouts/Partials/NotificationBar.vue";

const props = defineProps({
  title: String,
});

const currentTitle = computed(
  () => props.title ?? usePage().props.breadcrumbs.at(-1)?.title
);
</script>

<template>
  <div>
    <Head :title="currentTitle" />

    <div class="min-h-screen bg-gray-200 dark:bg-gray-900">
      <!-- navbar -->
      <NavBar :user="$page.props.auth.user" />

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
