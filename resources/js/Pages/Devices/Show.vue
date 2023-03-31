<script setup>
import { formatDate } from "@/Shared/utils";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import DropdownDivider from "@/Components/Menu/DropdownDivider.vue";
import DropdownHeader from "@/Components/Menu/DropdownHeader.vue";
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

const statusActions = [
  {
    label: "Check In",
    icon: "box-arrow-in-right",
    value: "checked_in",
  },
  {
    label: "Start Reparing",
    icon: "wrench",
    value: "in_repair",
  },
  {
    label: "Put On Hold",
    icon: "pause-circle",
    value: "on_hold",
  },
  {
    label: "Mark as Fixed",
    icon: "check2-circle",
    value: "fixed",
  },
  {
    label: "Mark as Defect",
    icon: "x-circle",
    value: "defect",
  },
  {
    label: "Check Out",
    icon: "box-arrow-in-left",
    value: "checked_out",
  },
];
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

      <Dropdown label="Change Status" icon="arrow-repeat">
        <DropdownItem
          v-for="action in statusActions"
          v-show="action.value != device.status"
          :key="action.value"
          :label="action.label"
          :icon="action.icon"
          :href="route('devices.update', device.id)"
          :data="{ status: action.value }"
          method="put"
        />
      </Dropdown>

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
        <DropdownItem
          label="New Ticket"
          icon="create"
          :href="route('tickets.create')"
          :data="{ device_id: device.id }"
        />

        <DropdownDivider />

        <DropdownHeader label="Change Status" />

        <DropdownItem
          v-for="action in statusActions"
          v-show="action.value != device.status"
          :key="action.value"
          :label="action.label"
          :icon="action.icon"
          :href="route('devices.update', device.id)"
          :data="{ status: action.value }"
          method="put"
        />
      </Dropdown>
    </template>

    <template #aside>
      <DeviceCard :device="device" />
    </template>

    <template #content>
      <Card flush>
        <template #header>
          <h5>
            Tickets
            <span class="ml-1 opacity-50">
              {{ device.closed_tickets_count }}/
              {{ device.total_tickets_count }}
            </span>
          </h5>
        </template>
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
