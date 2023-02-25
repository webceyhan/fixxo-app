<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div
                            v-for="(value, key) in user"
                            :key="key"
                            class="mb-4"
                        >
                            <strong>{{ key }}:</strong> {{ value }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
