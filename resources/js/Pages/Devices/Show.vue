<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import DropdownDivider from "@/Components/Menu/DropdownDivider.vue";
import DropdownHeader from "@/Components/Menu/DropdownHeader.vue";
import DeviceCard from "./Partials/DeviceCard.vue";
import DeviceTickets from "./Partials/DeviceTickets.vue";
import DeviceHistory from "./Partials/DeviceHistory.vue";

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
      <DeviceTickets :device="device" :tickets="device.tickets" />

      <DeviceHistory :logs="device.logs" />
    </template>
  </PageLayout>
</template>
