<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps(["title"]);
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-1 pb-6">
                    <slot name="actions" />
                </div>

                <div class="flex gap-6">
                    <div v-if="$slots.sidenav" class="w-1/4 flex-shrink-0">
                        <slot name="sidenav" />
                    </div>

                    <div
                        class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
