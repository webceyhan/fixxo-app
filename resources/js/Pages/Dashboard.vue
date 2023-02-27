<script setup>
import { Head } from "@inertiajs/vue3";
import StatCard from "@/Components/StatCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-8">
                    <StatCard
                        label="Assets"
                        :items="[
                            { label: 'In Progress', value: 8 },
                            { label: 'Ready', value: 2 },
                        ]"
                    />

                    <StatCard
                        label="Tasks"
                        :items="[
                            { label: 'Pending', value: 10 },
                            { label: 'Completed', value: 23 },
                        ]"
                    />

                    <StatCard
                        label="Earnings"
                        :items="[
                            { label: 'Labor Cost', value: '120€' },
                            { label: 'Due Pay', value: '300€' },
                        ]"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
