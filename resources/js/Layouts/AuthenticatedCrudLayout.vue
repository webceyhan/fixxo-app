<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps(["title"]);
</script>

<template>
    <AuthenticatedLayout :title="title">
        <div class="container mx-auto sm:px-6 lg:px-8 py-12">
            <div class="px-1 pb-6">
                <slot name="actions" />
            </div>

            <slot />
        </div>
    </AuthenticatedLayout>
</template>
