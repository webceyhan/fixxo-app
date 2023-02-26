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
                    <StatCard label="Assets">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:divide-x divide-slate-500">
                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">In Progress</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">8</dd>
                            </div>

                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">Ready</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">2</dd>
                            </div>
                        </dl>
                    </StatCard>

                    <StatCard label="Tasks">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:divide-x divide-slate-500">
                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">Pending</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">10</dd>
                            </div>

                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">Completed</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">23</dd>
                            </div>
                        </dl>
                    </StatCard>

                    <StatCard label="Earnings">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:divide-x divide-slate-500">
                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">Labor cost</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">120€</dd>
                            </div>

                            <div class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8">
                                <dt class="text-base leading-7 dark:text-gray-400">Due paid</dt>
                                <dd class="text-2xl font-bold leading-9 tracking-tight dark:text-white">300€</dd>
                            </div>
                        </dl>
                     </StatCard>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
