<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    customers: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Customers">
        <ul class="divide-y divide-slate-200">
            <li v-for="user in customers" :key="user.id">
                <Link
                    :href="route('customers.show', user.id)"
                    class="flex p-4 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    {{ user.name }}
                </Link>
            </li>
        </ul>
    </AuthenticatedCrudLayout>
</template>
