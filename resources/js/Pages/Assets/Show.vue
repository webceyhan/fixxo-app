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
import TaskList from "@/Pages/Tasks/Partials/TaskList.vue";
import TaskModal from "@/Pages/Tasks/Partials/TaskModal.vue";
import PaymentList from "@/Pages/Payments/Partials/PaymentList.vue";
import PaymentModal from "@/Pages/Payments/Partials/PaymentModal.vue";

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

// Task Modal
const taskModal = ref(null);
const editedTask = ref(null);

const createTask = () => {
  editTask({ asset_id: props.asset.id });
};

const editTask = (task) => {
  editedTask.value = task;
  taskModal.value.open();
};

// Payment Modal
const paymentModal = ref(null);
const editedPayment = ref(null);

const createPayment = () => {
  editPayment({ asset_id: props.asset.id });
};

const editPayment = (payment) => {
  editedPayment.value = payment;
  paymentModal.value.open();
};
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
      <PrimaryButton label="New Task" icon="create" @click="createTask" />
      <PrimaryButton label="New Payment" icon="create" @click="createPayment" />
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
        <DropdownItem label="New Task" icon="create" @click="createTask" />
        <DropdownItem label="New Payment" icon="create" @click="createPayment" />
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

      <Card label="Tasks" flush>
        <TaskList :tasks="tasks" @select="editTask" />
        <TaskModal :task="editedTask" ref="taskModal" />
      </Card>

      <Card label="Payments" flush>
        <PaymentList :payments="payments" @select="editPayment" />
        <PaymentModal :payment="editedPayment" ref="paymentModal" />
      </Card>
    </template>
  </PageLayout>
</template>
