<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";
import AssetCard from "@/Pages/Assets/Partials/AssetCard.vue";
import AssetTasks from "./Partials/AssetTasks.vue";
import AssetPayments from "./Partials/AssetPayments.vue";
import SignatureModal from "./Partials/SignatureModal.vue";
import Receipt from "./Partials/Receipt.vue";
import AssetUploads from "./Partials/AssetUploads.vue";
import Icon from "@/Components/Icon.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
  asset: Object,
  tasks: Array,
  payments: Array,
});

const toggleProblemEdit = ref(false);
const toggleNotesEdit = ref(false);

const form = useForm({
  problem: props.asset.problem,
  notes: props.asset.notes,
});

const save = () => {
  form.put(route("assets.update", props.asset.id), {
    preserveScroll: true,
  });
  return true; // return true to close the edit
};

// Partial refs
const assetTasks = ref(null);
const assetPayments = ref(null);
const signatureModal = ref(null);

const printing = ref();

const print = (type) => {
  printing.value = type;
  setTimeout(() => {
    window.print();
    printing.value = null;
  }, 100);
};
</script>

<template>
  <PageLayout :title="asset.name" class="print:hidden">
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
      />

      <SecondaryButton label="Sign" icon="sign" @click="signatureModal.open()" />

      <Dropdown label="Print" icon="print">
        <DropdownItem label="Intake Receipt" icon="file-pdf" @click="print('intake')" />
        <DropdownItem
          label="Delivery Receipt"
          icon="file-pdf"
          @click="print('delivery')"
        />
      </Dropdown>

      <Dropdown icon="create" label="New" primary>
        <DropdownItem label="New Task" icon="create" @click="assetTasks.create()" />
        <DropdownItem label="New Payment" icon="create" @click="assetPayments.create()" />
        <!-- <hr class="bg-gray-200 dark:bg-gray-600 border-0 h-px" /> -->
      </Dropdown>
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
        <div
          v-if="!toggleNotesEdit"
          class="relative group"
          @click="toggleNotesEdit = true"
        >
          <pre class="whitespace-pre-wrap text-sm">{{ asset.notes ?? "Add notes..." }}</pre>
          <Icon name="edit" class="absolute top-0 right-0 hidden group-hover:block" />
        </div>

        <div v-if="toggleNotesEdit">
          <Textarea
            rows="5"
            class="block w-full text-sm font-mono mb-4"
            v-model="form.notes"
            autofocus
          />
          <PrimaryButton
            label="Save"
            class="mr-2"
            @click="save() && (toggleNotesEdit = false)"
          />
          <SecondaryButton label="Cancel" @click="toggleNotesEdit = false" />
        </div>
      </Card>

      <AssetUploads :asset="asset" />
    </template>

    <template #content>
      <Card label="Problem">
        <div
          v-if="!toggleProblemEdit"
          class="relative group"
          @click="toggleProblemEdit = true"
        >
          <pre class="whitespace-pre-wrap text-sm">{{ asset.problem ?? "Add problem..." }}</pre>
          <Icon name="edit" class="absolute top-0 right-0 hidden group-hover:block" />
        </div>

        <div v-if="toggleProblemEdit">
          <Textarea
            rows="5"
            class="block w-full text-sm font-mono mb-4"
            v-model="form.problem"
            autofocus
          />
          <PrimaryButton
            label="Save"
            class="mr-2"
            @click="save() && (toggleProblemEdit = false)"
          />
          <SecondaryButton label="Cancel" @click="toggleProblemEdit = false" />
        </div>
      </Card>

      <AssetTasks v-bind="{ asset, tasks }" ref="assetTasks" />

      <AssetPayments v-bind="{ asset, payments }" ref="assetPayments" />

      <SignatureModal :asset="asset" ref="signatureModal" />
    </template>
  </PageLayout>

  <!-- print only content here -->
  <section class="hidden print:block">
    <Receipt v-if="printing === 'intake'" :asset="asset" />
    <Receipt
      v-else-if="printing === 'delivery'"
      v-bind="{ asset, tasks, payments }"
      delivery
    />
  </section>
</template>
