<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    asset: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="asset.name">
        <div class="divide-y divide-slate-200">
            <div v-for="(value, key) in asset" :key="key" class="flex p-4">
                <div class="w-full overflow-hidden sm:flex gap-x-4">
                    <p class="w-1/5 text-slate-900">{{ key }}</p>
                    <p class="text-slate-500 truncate">{{ value }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedCrudLayout>
</template>
