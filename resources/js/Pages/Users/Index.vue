<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    users: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Users">
        <ul class="divide-y divide-slate-200">
            <li v-for="user in users" :key="user.id">
                <Link
                    :href="route('users.show', user.id)"
                    class="flex p-4 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    {{ user.name }}
                </Link>
            </li>
        </ul>
    </AuthenticatedCrudLayout>
</template>
