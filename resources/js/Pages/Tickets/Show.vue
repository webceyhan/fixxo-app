<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Icon from "@/Components/Icon.vue";
import Card from "@/Components/Card.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import DropdownDivider from "@/Components/Menu/DropdownDivider.vue";
import DropdownHeader from "@/Components/Menu/DropdownHeader.vue";
import TicketCard from "./Partials/TicketCard.vue";
import TicketTasks from "./Partials/TicketTasks.vue";
import TicketOrders from "./Partials/TicketOrders.vue";
import TicketTransactions from "./Partials/TicketTransactions.vue";
import SignatureModal from "./Partials/SignatureModal.vue";
import TicketUploads from "./Partials/TicketUploads.vue";
import Receipt from "./Partials/Receipt.vue";

const props = defineProps({
  ticket: Object,
  tasks: Array,
  orders: Array,
  transactions: Array,
  canDelete: Boolean,
  canDeleteTask: Boolean,
  canDeleteOrder: Boolean,
  canDeleteTransaction: Boolean,
});

const toggleDescriptionEdit = ref(false);

const form = useForm({
  description: props.ticket.description,
});

const save = () => {
  form.put(route("tickets.update", props.ticket.id), {
    preserveScroll: true,
  });
  return true; // return true to close the edit
};

// Partial refs
const ticketTasks = ref(null);
const ticketTransactions = ref(null);
const signatureModal = ref(null);

const printing = ref();

const print = (type) => {
  printing.value = type;
  setTimeout(() => {
    window.print();
    printing.value = null;
  }, 100);
};

const statusActions = [
  {
    label: "Open",
    value: "new",
    icon: "arrow-repeat",
  },
  {
    label: "Dispatch",
    value: "in_progress",
    icon: "play",
  },
  {
    label: "Put On Hold",
    value: "on_hold",
    icon: "pause",
  },
  {
    label: "Mark as Resolved",
    value: "resolved",
    icon: "check",
  },
  {
    label: "Close",
    value: "closed",
    icon: "x",
  },
];
</script>

<template>
  <PageLayout :title="`Ticket #${ticket.id}`" class="print:hidden">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton
        label="Edit"
        icon="edit"
        :href="route('tickets.edit', ticket.id)"
      />
      <DangerButton
        v-if="canDelete"
        label="Delete"
        method="delete"
        icon="delete"
        :href="route('tickets.destroy', ticket.id)"
        class="mr-4"
      />

      <Dropdown label="Change Status" icon="arrow-repeat">
        <DropdownItem
          v-for="action in statusActions"
          v-show="action.value != ticket.status"
          :key="action.value"
          :label="action.label"
          :icon="action.icon"
          :href="route('tickets.update', ticket.id)"
          :data="{ status: action.value }"
          method="put"
        />
      </Dropdown>

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
        <DropdownItem label="New Task" icon="create" @click="ticketTasks.create()" />
        <DropdownItem
          label="New Transaction"
          icon="create"
          @click="ticketTransactions.create()"
        />
        <!-- <hr class="bg-gray-200 dark:bg-gray-600 border-0 h-px" /> -->
      </Dropdown>
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem label="Edit" icon="edit" :href="route('tickets.edit', ticket.id)" />
        <DropdownItem
          v-if="canDelete"
          label="Delete"
          method="delete"
          icon="delete"
          :href="route('tickets.destroy', ticket.id)"
        />
        <DropdownItem label="New Task" icon="create" @click="ticketTasks.create()" />
        <DropdownItem
          label="New Transaction"
          icon="create"
          @click="ticketTransactions.create()"
        />
        <DropdownItem label="Sign" icon="sign" @click="signatureModal.open()" />

        <DropdownDivider />

        <DropdownHeader label="Change Status" />

        <DropdownItem
          v-for="action in statusActions"
          v-show="action.value != ticket.status"
          :key="action.value"
          :label="action.label"
          :icon="action.icon"
          :href="route('tickets.update', ticket.id)"
          :data="{ status: action.value }"
          method="put"
        />
      </Dropdown>
    </template>

    <template #aside>
      <TicketCard :ticket="ticket" />

      <TicketUploads :ticket="ticket" />
    </template>

    <template #content>
      <Card title="Description">
        <div
          v-if="!toggleDescriptionEdit"
          class="relative group"
          @click="toggleDescriptionEdit = true"
        >
          <pre
            class="whitespace-pre-wrap text-sm"
            v-html="ticket.description ?? 'Add description...'"
          />

          <Icon name="edit" class="absolute top-0 right-0 hidden group-hover:block" />
        </div>

        <div v-if="toggleDescriptionEdit">
          <Textarea
            rows="5"
            class="block w-full text-sm font-mono mb-4"
            v-model="form.description"
            autofocus
          />
          <PrimaryButton
            label="Save"
            class="mr-2"
            @click="save() && (toggleDescriptionEdit = false)"
          />
          <SecondaryButton label="Cancel" @click="toggleDescriptionEdit = false" />
        </div>
      </Card>

      <TicketTasks
        ref="ticketTasks"
        v-bind="{ ticket, tasks }"
        :can-delete="canDeleteTask"
      />

      <TicketOrders
        ref="ticketOrders"
        v-bind="{ ticket, orders }"
        :can-delete="canDeleteOrder"
      />

      <TicketTransactions
        ref="ticketTransactions"
        v-bind="{ invoice:ticket.invoice, transactions }"
        :can-delete="canDeleteTransaction"
      />

      <SignatureModal :ticket="ticket" ref="signatureModal" />
    </template>
  </PageLayout>

  <!-- print only content here -->
  <section class="hidden print:block">
    <Receipt v-if="printing === 'intake'" :ticket="ticket" />
    <Receipt
      v-else-if="printing === 'delivery'"
      v-bind="{ ticket, tasks, transactions }"
      delivery
    />
  </section>
</template>
