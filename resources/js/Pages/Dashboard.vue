<script setup>
import { router } from "@inertiajs/vue3";
import Link from "@/Components/Link.vue";
import Card from "@/Components/Card.vue";
import StatCard from "@/Components/StatCard.vue";
import AssetList from "@/Pages/Assets/Partials/AssetList.vue";
import RadioGroup from "@/Components/Form/RadioGroup.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Select from "@/Components/Form/Select.vue";
import SingleStatCard from "@/Components/SingleStatCard.vue";

const props = defineProps({
  interval: String,
  intervalOptions: Object,
  earningStats: Array,
  taskStats: Array,
  assetStats: Array,
  assetsReady: Array,
  assetsInProgress: Array,
  assetsUnpaid: Array,
  //
  totalCustomers: Number,
  totalAssets: Number,
  totalTasks: Number,
  totalPayments: Number,
});

const onIntervalChange = (interval) => {
  router.reload({ data: { interval } });
};
</script>

<template>
  <AuthenticatedLayout title="Dashboard">
    <div class="flex items-center md:justify-end">
      <RadioGroup
        class="hidden lg:flex"
        :modelValue="interval"
        :options="intervalOptions"
        @update:modelValue="onIntervalChange"
        fancy
      />

      <Select
        class="lg:hidden"
        :options="intervalOptions"
        :modelValue="interval"
        @update:modelValue="onIntervalChange"
      />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
      <SingleStatCard
        label="Total Customers"
        icon="people"
        icon-bg-color="bg-indigo-600/50"
        :value="totalCustomers"
      />

      <SingleStatCard
        label="Total Assets"
        icon="asset"
        icon-bg-color="bg-pink-600/50"
        :value="totalAssets"
      />

      <SingleStatCard
        label="Total Tasks"
        icon="task"
        icon-bg-color="bg-green-600/50"
        :value="totalTasks"
      />

      <SingleStatCard
        label="Total Payments"
        icon="payment"
        icon-bg-color="bg-orange-600/50"
        :value="totalPayments"
      />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
      <StatCard
        label="Assets"
        icon="asset"
        :items="assetStats"
        class="!border-blue-500/25"
      />

      <StatCard
        label="Tasks"
        icon="task"
        :items="taskStats"
        class="!border-green-500/25"
      />

      <StatCard
        label="Earnings"
        icon="money"
        :items="earningStats"
        class="!border-yellow-500/25"
        format-as-money
      />
    </div>

    <div class="flex flex-col md:flex-row md:flex-wrap gap-6 lg:gap-8">
      <Card class="flex-1" label="Latest assets in progress" flush>
        <AssetList :assets="assetsInProgress" compact />

        <!-- placeholder -->
        <div v-if="assetsInProgress.length === 0" class="text-center py-10">
          No assets found.
        </div>

        <template #footer>
          <Link
            label="View all"
            :href="route('assets.index', { status: 'in_progress' })"
          />
        </template>
      </Card>

      <Card class="flex-1" label="Latest assets ready to pick up" flush>
        <AssetList :assets="assetsReady" compact />

        <!-- placeholder -->
        <div v-if="assetsReady.length === 0" class="text-center py-10">
          No assets found.
        </div>

        <template #footer>
          <Link label="View all" :href="route('assets.index', { status: 'ready' })" />
        </template>
      </Card>

      <Card class="sm:w-full" label="Unpaid returned assets" flush>
        <AssetList :assets="assetsUnpaid" />

        <!-- placeholder -->
        <div v-if="assetsUnpaid.length === 0" class="text-center py-10">
          No assets found.
        </div>

        <template #footer>
          <Link label="View all" :href="route('assets.index', { status: 'unpaid' })" />
        </template>
      </Card>
    </div>
  </AuthenticatedLayout>
</template>
