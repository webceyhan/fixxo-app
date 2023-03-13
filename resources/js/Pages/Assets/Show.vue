<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { formatMoney } from "@/Shared/utils";
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

// Calculate balance
const balance = computed(() => {
  const cost = props.tasks.reduce((sum, { price }) => sum + +price, 0);

  const sumByType = props.payments.reduce((acc, { type, amount }) => {
    acc[type] = (acc[type] || 0) + +amount;
    return acc;
  }, {});

  const { charge, refund, discount, warranty } = sumByType;

  const total =
    (charge ?? 0) - cost + (Math.abs(discount ?? 0) + Math.abs(warranty ?? 0));

  return {
    cost,
    charge,
    discount,
    warranty,
    refund,
    total,
  };
});
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

        <template #footer>
          <span class="w-full text-right">Total Cost</span>
          <span class="w-2/3 mr-7 sm:mr-9 text-right">
            {{ formatMoney(balance.cost) }}
          </span>
        </template>
      </Card>

      <Card label="Balance" flush>
        <PaymentList :payments="payments" @select="editPayment" />
        <PaymentModal :payment="editedPayment" ref="paymentModal" />

        <template #footer>
          <div class="w-full text-right">
            <div class="flex">
              <span class="w-full">cost</span>
              <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
                {{ formatMoney(balance.cost) }}
              </span>
            </div>

            <template
              v-for="type in ['discount', 'warranty', 'charge', 'refund']"
              :key="type"
            >
              <div v-if="balance[type]" class="flex">
                <span class="w-full">{{ type }}</span>
                <span class="w-2/3 mr-7 sm:mr-9 border-b border-gray-700 border-dashed">
                  {{ formatMoney(balance[type]) }}
                </span>
              </div>
            </template>

            <div class="flex">
              <span
                class="w-full mr-7 sm:mr-9 text-xl mt-1 text-white/50"
                :class="{ '!text-red-500': balance.total < 0 }"
              >
                {{ formatMoney(balance.total) }}
              </span>
            </div>
          </div>
        </template>
      </Card>
    </template>
  </PageLayout>
</template>
