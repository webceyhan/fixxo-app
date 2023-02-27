<script setup>
import { Head, Link } from "@inertiajs/vue3";
import StatCard from "@/Components/StatCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from "@/Components/Card.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

const props = defineProps({
    assetsReady: Array,
    assetsInProgress: Array,
});
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
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

                <div class="flex flex-col sm:flex-row gap-5">
                    <Card class="flex-1" label="Latest assets in progress">
                        <StackedList class="-mx-4">
                            <StackedListItem
                                v-for="asset in assetsInProgress"
                                :key="asset.id"
                                :href="route('assets.show', asset.id)"
                            >
                                <span class="w-2/3">
                                    {{ asset.brand }} {{ asset.name }}
                                    <br />
                                    <span class="text-sm text-gray-400">
                                        {{ asset.customer.name }}
                                    </span>
                                </span>

                                <span
                                    class="px-2.5 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-sm"
                                >
                                    {{ asset.status }}
                                </span>
                            </StackedListItem>
                        </StackedList>

                        <div class="flex justify-end mt-4 px-1">
                            <Link
                                class="text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                                :href="
                                    route('assets.index', {
                                        status: 'in_progress',
                                    })
                                "
                            >
                                View all
                            </Link>
                        </div>
                    </Card>

                    <Card class="flex-1" label="Latest assets ready to pick up">
                        <StackedList class="-mx-4">
                            <StackedListItem
                                v-for="asset in assetsReady"
                                :key="asset.id"
                                :href="route('assets.show', asset.id)"
                            >
                                <span class="w-2/3">
                                    {{ asset.brand }} {{ asset.name }}
                                    <br />
                                    <span class="text-sm text-gray-400">
                                        {{ asset.customer.name }}
                                    </span>
                                </span>

                                <span
                                    class="px-2.5 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-sm"
                                >
                                    {{ asset.status }}
                                </span>
                            </StackedListItem>
                        </StackedList>

                        <div class="flex justify-end mt-4 px-1">
                            <Link
                                class="text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                                :href="
                                    route('assets.index', { status: 'ready' })
                                "
                            >
                                View all
                            </Link>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
