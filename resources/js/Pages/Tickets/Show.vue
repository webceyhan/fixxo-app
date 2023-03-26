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
import TicketCard from "@/Pages/Tickets/Partials/TicketCard.vue";
import TicketTasks from "./Partials/TicketTasks.vue";
import TicketPayments from "./Partials/TicketPayments.vue";
import SignatureModal from "./Partials/SignatureModal.vue";
import Receipt from "./Partials/Receipt.vue";
import TicketUploads from "./Partials/TicketUploads.vue";
import Icon from "@/Components/Icon.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
  ticket: Object,
  tasks: Array,
  payments: Array,
  canDelete: Boolean,
  canDeleteTask: Boolean,
  canDeletePayment: Boolean,
});

const toggleSubjectEdit = ref(false);
const toggleNoteEdit = ref(false);

const form = useForm({
  subject: props.ticket.subject,
  note: props.ticket.note,
});

const save = () => {
  form.put(route("tickets.update", props.ticket.id), {
    preserveScroll: true,
  });
  return true; // return true to close the edit
};

// Partial refs
const ticketTasks = ref(null);
const ticketPayments = ref(null);
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
      <ToggleButton
        name="status"
        :value="ticket.status"
        :href="route('tickets.update', ticket.id)"
        :options="{
          new: 'Reopen',
          in_progress: 'Dispatch',
          on_hold: 'Hold',
          resolved: 'Resolve',
          closed: 'Close',
        }"
        :icons="{
          new: 'arrow-repeat',
          in_progress: 'arrow-repeat',
          on_hold: 'pause-circle',
          resolved: 'check-circle',
          closed: 'x-circle',
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
        <DropdownItem label="New Task" icon="create" @click="ticketTasks.create()" />
        <DropdownItem
          label="New Payment"
          icon="create"
          @click="ticketPayments.create()"
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
        <DropdownToggleItem
          name="status"
          :value="ticket.status"
          :href="route('tickets.update', ticket.id)"
          :options="{
            new: 'Reopen',
            in_progress: 'Dispatch',
            on_hold: 'Hold',
            resolved: 'Resolve',
            closed: 'Close',
          }"
          :icons="{
            new: 'arrow-repeat',
            in_progress: 'arrow-repeat',
            on_hold: 'pause-circle',
            resolved: 'check-circle',
            closed: 'x-circle',
          }"
          method="put"
        />
        <DropdownItem label="New Task" icon="create" @click="ticketTasks.create()" />
        <DropdownItem
          label="New Payment"
          icon="create"
          @click="ticketPayments.create()"
        />
        <DropdownItem label="Sign" icon="sign" @click="signatureModal.open()" />
      </Dropdown>
    </template>

    <template #aside>
      <TicketCard :ticket="ticket" />

      <Card label="Note">
        <div v-if="!toggleNoteEdit" class="relative group" @click="toggleNoteEdit = true">
          <pre
            class="whitespace-pre-wrap text-sm"
            v-html="ticket.note ?? 'Add note...'"
          />

          <Icon name="edit" class="absolute top-0 right-0 hidden group-hover:block" />
        </div>

        <div v-if="toggleNoteEdit">
          <Textarea
            rows="5"
            class="block w-full text-sm font-mono mb-4"
            v-model="form.note"
            autofocus
          />
          <PrimaryButton
            label="Save"
            class="mr-2"
            @click="save() && (toggleNoteEdit = false)"
          />
          <SecondaryButton label="Cancel" @click="toggleNoteEdit = false" />
        </div>
      </Card>

      <TicketUploads :ticket="ticket" />
    </template>

    <template #content>
      <Card label="Subject">
        <div
          v-if="!toggleSubjectEdit"
          class="relative group"
          @click="toggleSubjectEdit = true"
        >
          <pre
            class="whitespace-pre-wrap text-sm"
            v-html="ticket.subject ?? 'Add subject...'"
          />

          <Icon name="edit" class="absolute top-0 right-0 hidden group-hover:block" />
        </div>

        <div v-if="toggleSubjectEdit">
          <Textarea
            rows="5"
            class="block w-full text-sm font-mono mb-4"
            v-model="form.subject"
            autofocus
          />
          <PrimaryButton
            label="Save"
            class="mr-2"
            @click="save() && (toggleSubjectEdit = false)"
          />
          <SecondaryButton label="Cancel" @click="toggleSubjectEdit = false" />
        </div>
      </Card>

      <TicketTasks
        ref="ticketTasks"
        v-bind="{ ticket, tasks }"
        :can-delete="canDeleteTask"
      />

      <TicketPayments
        ref="ticketPayments"
        v-bind="{ ticket, payments }"
        :can-delete="canDeletePayment"
      />

      <SignatureModal :ticket="ticket" ref="signatureModal" />
    </template>
  </PageLayout>

  <!-- print only content here -->
  <section class="hidden print:block">
    <Receipt v-if="printing === 'intake'" :ticket="ticket" />
    <Receipt
      v-else-if="printing === 'delivery'"
      v-bind="{ ticket, tasks, payments }"
      delivery
    />
  </section>
</template>