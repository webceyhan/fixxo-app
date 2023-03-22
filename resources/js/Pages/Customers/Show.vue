<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import AssetList from "../Assets/Partials/AssetList.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import CustomerCard from "./Partials/CustomerCard.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";

const props = defineProps({
  customer: Object,
  assets: Array,
});

const form = useForm({
  notes: props.customer.notes,
});

const save = () => {
  form.put(route("customers.update", props.customer.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <PageLayout :title="customer.name">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton
        label="Edit"
        icon="edit"
        :href="route('customers.edit', customer.id)"
      />
      <DangerButton
        label="Delete"
        method="delete"
        icon="delete"
        :href="route('customers.destroy', customer.id)"
        class="mr-4"
      />
      <ToggleButton
        name="status"
        :value="customer.status"
        :href="route('customers.update', customer.id)"
        :options="{
          active: 'Unlock',
          inactive: 'Lock',
        }"
        :icons="{
          active: 'unlock',
          inactive: 'lock',
        }"
        method="put"
        class="mr-4"
      />

      <PrimaryButton
        label="New Asset"
        icon="create"
        :href="route('assets.create')"
        :data="{ customer_id: customer.id }"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem
          label="Edit"
          icon="edit"
          :href="route('customers.edit', customer.id)"
        />
        <DropdownItem
          label="Delete"
          method="delete"
          icon="delete"
          :href="route('customers.destroy', customer.id)"
        />
        <DropdownToggleItem
          name="status"
          :value="customer.status"
          :href="route('customers.update', customer.id)"
          :options="{
            active: 'Unlock',
            inactive: 'Lock',
          }"
          :icons="{
            active: 'unlock',
            inactive: 'lock',
          }"
          method="put"
        />
        <DropdownItem
          label="New Asset"
          icon="create"
          :href="route('assets.create')"
          :data="{ customer_id: customer.id }"
        />
      </Dropdown>
    </template>

    <template #aside>
      <CustomerCard :customer="customer" />

      <Card label="Notes">
        <Textarea
          rows="5"
          class="block w-full mb-4"
          placeholder="Add notes..."
          v-model="form.notes"
        />
        <SecondaryButton label="Save" @click="save" />
      </Card>
    </template>

    <template #content>
      <Card label="Assets" flush>
        <AssetList :assets="assets" />
      </Card>
    </template>
  </PageLayout>
</template>
