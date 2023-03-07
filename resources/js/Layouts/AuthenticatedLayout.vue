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

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- navbar -->
      <NavBar :user="$page.props.auth.user" />

      <header class="container mx-auto pt-6 px-4 sm:px-6 lg:px-8">
        <Breadcrumbs :links="$page.props.breadcrumbs" class="hidden md:flex" />
        <h2 class="text-2xl text-white md:hidden">{{ currentTitle }}</h2>
      </header>

      <!-- Page Heading -->
      <!-- <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header || title">
        <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header">
            <h2
              class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
              {{ title }}
            </h2>
          </slot>
        </div>
      </header> -->

      <!-- Page Content -->
      <main class="container mx-auto sm:px-6 lg:px-8 py-8 space-y-6">
        <slot />
      </main>

      <!-- notifications -->
      <NotificationBar :message="$page.props.flash.status" />
    </div>
  </div>
</template>
