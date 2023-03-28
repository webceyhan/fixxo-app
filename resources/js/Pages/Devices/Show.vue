<script setup>
import { formatDate } from "@/Shared/utils";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";
import TicketList from "@/Pages/Tickets/Partials/TicketList.vue";
import DeviceCard from "./Partials/DeviceCard.vue";
import DeviceBadge from "./Partials/DeviceBadge.vue";

const props = defineProps({
  device: Object,
  canDelete: Boolean,
  // canDeleteTicket: Boolean,
});

const save = () => {
  form.put(route("devices.update", props.device.id), {
    preserveScroll: true,
  });
  return true; // return true to close the edit
};
</script>

<template>
  <PageLayout :title="device.name">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton
        label="Edit"
        icon="edit"
        :href="route('devices.edit', device.id)"
      />
      <DangerButton
        v-if="canDelete"
        label="Delete"
        method="delete"
        icon="delete"
        :href="route('devices.destroy', device.id)"
        class="mr-4"
      />
      <ToggleButton
        name="status"
        :value="device.status"
        :href="route('devices.update', device.id)"
        :options="{
          checked_in: 'Check In',
          diagnosing: 'Diagnose',
          repairing: 'Repair',
          fixed: 'Fixed',
          checked_out: 'Check Out',
        }"
        :icons="{
          checked_in: 'box-arrow-in-right',
          diagnosing: 'tools',
          repairing: 'wrench',
          fixed: 'check2-circle',
          checked_out: 'box-arrow-in-left',
        }"
        method="put"
      />
      <SecondaryButton
        v-if="device.status == 'repairing'"
        label="Wont Fix"
        icon="x-circle"
        :href="route('devices.update', device.id)"
        :data="{ status: 'unfixable' }"
        method="put"
      />

      <PrimaryButton
        label="New Ticket"
        icon="create"
        :href="route('tickets.create')"
        :data="{ device_id: device.id }"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem label="Edit" icon="edit" :href="route('devices.edit', device.id)" />
        <DropdownItem
          v-if="canDelete"
          label="Delete"
          method="delete"
          icon="delete"
          :href="route('devices.destroy', device.id)"
        />
        <DropdownToggleItem
          name="status"
          :value="device.status"
          :href="route('devices.update', device.id)"
          :options="{
            checked_in: 'Check In',
            diagnosing: 'Diagnose',
            repairing: 'Repair',
            fixed: 'Fixed',
            checked_out: 'Check Out',
          }"
          :icons="{
            checked_in: 'box-arrow-in-right',
            diagnosing: 'tools',
            repairing: 'wrench',
            fixed: 'check2-circle',
            checked_out: 'box-arrow-in-left',
          }"
          method="put"
        />
        <DropdownItem
          v-if="device.status == 'repairing'"
          label="Wont Fix"
          icon="x-circle"
          :href="route('devices.update', device.id)"
          :data="{ status: 'unfixable' }"
          method="put"
        />
        <DropdownItem
          label="New Ticket"
          icon="create"
          :href="route('tickets.create')"
          :data="{ device_id: device.id }"
        />
      </Dropdown>
    </template>

    <template #aside>
      <DeviceCard :device="device" />
    </template>

    <template #content>
      <Card label="Tickets" flush>
        <TicketList :tickets="device.tickets" />
      </Card>

      <!-- <Card label="History" class="!bg-opacity-25">  -->
      <h3 class="text-xl font-semibold dark:text-white pt-4">History</h3>
      <ol class="relative border-l border-gray-50 dark:border-gray-700 space-y-10">
        <li v-for="log in device.logs" :key="log.id" class="ml-4">
          <div
            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
          ></div>
          <time
            class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
          >
            {{ formatDate(log.created_at, true) }}
          </time>
          <p
            class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 space-x-2"
          >
            <span class="text-black dark:text-gray-200">{{ log.user.name }}</span>
            <span>changed status to</span>
            <DeviceBadge :status="log.status" class="dark:!bg-black/25" />
          </p>
        </li>
      </ol>
      <!-- </Card> -->
    </template>
  </PageLayout>
</template>
