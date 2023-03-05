<script setup>
import { router } from "@inertiajs/vue3";
import Link from "@/Components/Link.vue";
import Card from "@/Components/Card.vue";
import StatCard from "@/Components/StatCard.vue";
import AssetList from "@/Pages/Assets/Partials/AssetList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    interval: String,
    intervalOptions: Object,
    earningStats: Array,
    taskStats: Array,
    assetStats: Array,
    assetsReady: Array,
    assetsInProgress: Array,
});

const onIntervalChange = (interval) => {
    router.reload({ data: { interval } });
};
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <div class="flex items-center justify-end gap-5 px-5 sm:p-0">
            <div
                class="flex flex-col"
                v-for="(label, opt) in intervalOptions"
                :key="opt"
            >
                <label class="inline-flex items-center mt-3 sm:m-0">
                    <input
                        type="radio"
                        name="interval"
                        class="form-radio h-5 w-5 text-gray-600"
                        :checked="opt === interval"
                        @change="onIntervalChange(opt)"
                    />
                    <span class="ml-2 text-gray-500">{{ label }}</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
            <StatCard label="Assets" :items="assetStats" />

            <StatCard label="Tasks" :items="taskStats" />

            <StatCard label="Earnings" :items="earningStats" />
        </div>

        <div class="flex flex-col md:flex-row gap-5">
            <Card class="flex-1" label="Latest assets in progress" flush>
                <AssetList :assets="assetsInProgress" compact />

                <template #footer>
                    <Link
                        label="View all"
                        :href="route('assets.index', { status: 'in_progress' })"
                    />
                </template>
            </Card>

            <Card class="flex-1" label="Latest assets ready to pick up" flush>
                <AssetList :assets="assetsReady" compact />

                <template #footer>
                    <Link
                        label="View all"
                        :href="route('assets.index', { status: 'ready' })"
                    />
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
