<script setup>
import { router } from "@inertiajs/vue3";
import Link from "@/Components/Link.vue";
import Card from "@/Components/Card.vue";
import Select from "@/Components/Form/Select.vue";
import TabNav from "@/Components/Nav/TabNav.vue";
import TabNavItem from "@/Components/Nav/TabNavItem.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AssetList from "@/Pages/Assets/Partials/AssetList.vue";
import StatCard from "./Partials/StatCard.vue";
import SingleStatCard from "./Partials/SingleStatCard.vue";
import IncomeChart from "./Partials/IncomeChart.vue";

const props = defineProps({
  interval: String,
  intervalOptions: Object,
  //
  newCustomerStats: Object,
  newAssetStats: Object,
  newTaskStats: Object,
  newPaymentStats: Object,
  //
  incomeStats: Object,
  earningStats: Array,
  taskStats: Array,
  assetStats: Array,
  //
  assetsReady: Array,
  assetsInProgress: Array,
  assetsUnpaid: Array,
});

const onIntervalChange = (interval) => {
  router.reload({ data: { interval } });
};
</script>

<template>
  <AuthenticatedLayout title="Dashboard">
    <div class="flex items-center md:justify-end-">
      <TabNav class="hidden lg:flex w-full">
        <TabNavItem
          v-for="(link, key) in intervalOptions"
          :key="key"
          :label="link"
          :active="key === interval"
          :data="{ interval: key }"
        />
      </TabNav>

      <Select
        class="lg:hidden"
        :options="intervalOptions"
        :modelValue="interval"
        @update:modelValue="onIntervalChange"
      />
    </div>

    <StatCard label="Income">
      <IncomeChart v-bind="incomeStats" />
    </StatCard>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
      <SingleStatCard
        label="New Customers"
        icon="people"
        icon-bg-color="bg-indigo-600/50"
        v-bind="newCustomerStats"
      />

      <SingleStatCard
        label="New Assets"
        icon="asset"
        icon-bg-color="bg-pink-600/50"
        v-bind="newAssetStats"
      />

      <SingleStatCard
        label="New Tasks"
        icon="task"
        icon-bg-color="bg-green-600/50"
        v-bind="newTaskStats"
      />

      <SingleStatCard
        label="New Payments"
        icon="payment"
        icon-bg-color="bg-orange-600/50"
        v-bind="newPaymentStats"
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
