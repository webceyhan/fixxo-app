<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    tasks: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Tasks">
        <ul class="divide-y divide-slate-200">
            <li v-for="task in tasks" :key="task.id">
                <Link
                    :href="route('tasks.show', task.id)"
                    class="flex p-4 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    {{ task.description }}
                </Link>
            </li>
        </ul>
    </AuthenticatedCrudLayout>
</template>
