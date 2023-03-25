<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";
import DeviceCard from "@/Pages/Devices/Partials/DeviceCard.vue";

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

      <!-- <PrimaryButton
        label="New Ticket"
        icon="create"
        :href="route('tickets.create')"
        :data="{ device_id: device.id }"
      /> -->
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
        <!-- <DropdownItem label="New Ticket" icon="create" @click="deviceTasks.create()" /> -->
      </Dropdown>
    </template>

    <template #aside>
      <DeviceCard :device="device" />
    </template>

    <template #content>
      <!-- <DeviceTickets
        ref="deviceTickets"
        v-bind="{ device, tickets }"
        :can-delete="canDeleteTicket"
      /> -->
    </template>
  </PageLayout>
</template>
