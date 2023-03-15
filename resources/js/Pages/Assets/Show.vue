<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";
import AssetCard from "@/Pages/Assets/Partials/AssetCard.vue";
import AssetTasks from "./Partials/AssetTasks.vue";
import AssetPayments from "./Partials/AssetPayments.vue";
import SignatureModal from "./Partials/SignatureModal.vue";

const props = defineProps({
  asset: Object,
  tasks: Array,
  payments: Array,
});

const form = useForm({
  notes: props.asset.notes,
});

const save = () => {
  form.put(route("assets.update", props.asset.id), {
    preserveScroll: true,
  });
};

// Partial refs
const assetTasks = ref(null);
const assetPayments = ref(null);
const signatureModal = ref(null);

</script>

<template>
  <PageLayout :title="asset.name">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton label="Edit" icon="edit" :href="route('assets.edit', asset.id)" />
      <DangerButton
        label="Delete"
        method="delete"
        icon="delete"
        :href="route('assets.destroy', asset.id)"
        class="mr-4"
      />
      <ToggleButton
        name="status"
        :value="asset.status"
        :href="route('assets.update', asset.id)"
        :options="{
          in_progress: 'Reopen',
          ready: 'Resolve',
          returned: 'Return',
        }"
        :icons="{
          in_progress: 'arrow-repeat',
          ready: 'resolve',
          returned: 'return',
        }"
        method="put"
        class="mr-4"
      />
      <PrimaryButton label="New Task" icon="create" @click="assetTasks.create()" />
      <PrimaryButton label="New Payment" icon="create" @click="assetPayments.create()" />
      <PrimaryButton label="Sign" icon="sign" @click="signatureModal.open()" />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem label="Edit" icon="edit" :href="route('assets.edit', asset.id)" />
        <DropdownItem
          label="Delete"
          method="delete"
          icon="delete"
          :href="route('assets.destroy', asset.id)"
        />
        <DropdownToggleItem
          name="status"
          :value="asset.status"
          :href="route('assets.update', asset.id)"
          :options="{
            in_progress: 'Reopen',
            ready: 'Resolve',
            returned: 'Return',
          }"
          :icons="{
            in_progress: 'arrow-repeat',
            ready: 'resolve',
            returned: 'return',
          }"
          method="put"
        />
        <DropdownItem label="New Task" icon="create" @click="assetTasks.create()" />
        <DropdownItem label="New Payment" icon="create" @click="assetPayments.create()" />
        <DropdownItem label="Sign" icon="sign" @click="signatureModal.open()" />
      </Dropdown>
    </template>

    <template #aside>
      <AssetCard :asset="asset" />

      <Card label="Notes">
        <Textarea
          rows="5"
          class="w-full"
          placeholder="Add notes..."
          v-model="form.notes"
        />
        <SecondaryButton label="Save" @click="save" />
      </Card>
    </template>

    <template #content>
      <Card label="Problem">
        {{ asset.problem }}
      </Card>

      <AssetTasks v-bind="{ asset, tasks }" ref="assetTasks" />

      <AssetPayments v-bind="{ asset, payments }" ref="assetPayments" />

      <SignatureModal ref="signatureModal" />
    </template>
  </PageLayout>
</template>
