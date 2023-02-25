<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    assets: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Assets">
        <ul class="divide-y divide-slate-200">
            <li v-for="asset in assets" :key="asset.id">
                <Link
                    :href="route('assets.show', asset.id)"
                    class="flex p-4 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    {{ asset.brand }}
                    {{ asset.name }}
                </Link>
            </li>
        </ul>
    </AuthenticatedCrudLayout>
</template>
