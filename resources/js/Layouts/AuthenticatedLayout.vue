<script setup>
import { Head } from "@inertiajs/vue3";
import NavBar from "./Partials/NavBar.vue";
import NotificationBar from "./Partials/NotificationBar.vue";

defineProps(["title"]);
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- navbar -->
            <NavBar :user="$page.props.auth.user" />

            <!-- Page Heading -->
            <header
                class="bg-white dark:bg-gray-800 shadow"
                v-if="$slots.header || title"
            >
                <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header">
                        <h2
                            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        >
                            {{ title }}
                        </h2>
                    </slot>
                </div>
            </header>

            <!-- Page Content -->
            <main class="container mx-auto sm:px-6 lg:px-8 py-12 space-y-6">
                <!-- actions -->
                <div v-if="$slots.actions" class="px-1">
                    <slot name="actions" />
                </div>

                <slot />
            </main>

            <!-- notifications -->
            <NotificationBar :message="$page.props.flash.status" />
        </div>
    </div>
</template>
