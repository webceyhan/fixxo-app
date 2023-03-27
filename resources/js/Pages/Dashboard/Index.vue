<script setup>
import { router } from "@inertiajs/vue3";
import Link from "@/Components/Link.vue";
import Card from "@/Components/Card.vue";
import Select from "@/Components/Form/Select.vue";
import TabNav from "@/Components/Nav/TabNav.vue";
import TabNavItem from "@/Components/Nav/TabNavItem.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TicketList from "@/Pages/Tickets/Partials/TicketList.vue";
import StatCard from "./Partials/StatCard.vue";
import SingleStatCard from "./Partials/SingleStatCard.vue";
import IncomeChart from "./Partials/IncomeChart.vue";

const props = defineProps({
  interval: String,
  intervalOptions: Object,
  //
  newCustomerStats: Object,
  newTicketStats: Object,
  newTaskStats: Object,
  newPaymentStats: Object,
  //
  incomeStats: Object,
  ticketStats: Array,
  taskStats: Array,
  earningStats: Array,
  //
  ticketsInProgress: Array,
  ticketsResolved: Array,
  ticketsOutstanding: Array,
  ticketsOverdue: Array,
});

const labelMap = {
  day: "Hourly",
  week: "Daily",
  month: "Weekly",
  year: "Monthly",
};

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

    <StatCard :label="`${labelMap[interval]} Income`">
      <IncomeChart v-bind="incomeStats" color-class="bg-blue-500/75" />
    </StatCard>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
      <SingleStatCard
        label="New Customers"
        icon="people"
        icon-bg-color="bg-indigo-600/50"
        v-bind="newCustomerStats"
      />

      <SingleStatCard
        label="New Tickets"
        icon="ticket"
        icon-bg-color="bg-pink-600/50"
        v-bind="newTicketStats"
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
        label="Tickets"
        icon="ticket"
        :items="ticketStats"
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
      <Card class="lg:flex-1" label="Latest tickets in progress" flush>
        <TicketList :tickets="ticketsInProgress" compact with-task-count />

        <!-- placeholder -->
        <div v-if="ticketsInProgress.length === 0" class="text-center py-10">
          No tickets found.
        </div>

        <template #footer>
          <Link
            label="View all"
            :href="route('tickets.index', { status: 'in_progress' })"
          />
        </template>
      </Card>

      <Card class="lg:flex-1" label="Latest resolved tickets" flush>
        <TicketList :tickets="ticketsResolved" compact with-task-count />

        <!-- placeholder -->
        <div v-if="ticketsResolved.length === 0" class="text-center py-10">
          No tickets found.
        </div>

        <template #footer>
          <Link label="View all" :href="route('tickets.index', { status: 'ready' })" />
        </template>
      </Card>
    </div>
    <div class="flex flex-col md:flex-row md:flex-wrap gap-6 lg:gap-8">
      <Card class="lg:flex-1" label="Outstanding tickets" flush>
        <TicketList :tickets="ticketsOutstanding" compact with-balance />

        <!-- placeholder -->
        <div v-if="ticketsOutstanding.length === 0" class="text-center py-10">
          No tickets found.
        </div>

        <template #footer>
          <Link
            label="View all"
            :href="route('tickets.index', { status: 'outstanding' })"
          />
        </template>
      </Card>

      <Card class="lg:flex-1" label="Overdue tickets" flush>
        <TicketList :tickets="ticketsOverdue" compact with-balance />

        <!-- placeholder -->
        <div v-if="ticketsOverdue.length === 0" class="text-center py-10">
          No tickets found.
        </div>

        <template #footer>
          <Link label="View all" :href="route('tickets.index', { status: 'overdue' })" />
        </template>
      </Card>
    </div>
  </AuthenticatedLayout>
</template>
