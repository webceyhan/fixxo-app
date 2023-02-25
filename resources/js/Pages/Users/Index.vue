<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    users: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Link
                            v-for="user in users"
                            :key="user.id"
                            :href="route('users.show', user.id)"
                            class="block hover:bg-gray-200 dark:hover:bg-gray-700 px-4 py-2 rounded"
                        >
                            {{ user.name }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
