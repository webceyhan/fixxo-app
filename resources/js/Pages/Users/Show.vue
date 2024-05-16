<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import ToggleButton from "@/Components/Button/ToggleButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import DropdownToggleItem from "@/Components/Menu/DropdownToggleItem.vue";
import TicketList from "@/Pages/Tickets/Partials/TicketList.vue";
import UserCard from "./Partials/UserCard.vue";

const props = defineProps({
  user: Object,
  recentTickets: Array,
});
</script>

<template>
  <PageLayout :title="user.name">
    <!-- desktop menu -->
    <template #desktop-menu>
      <SecondaryButton label="Edit" icon="edit" :href="route('users.edit', user.id)" />
      <DangerButton
        label="Delete"
        icon="delete"
        method="delete"
        :href="route('users.destroy', user.id)"
        class="mr-4"
      />
      <ToggleButton
        name="status"
        :value="user.status"
        :href="route('users.update', user.id)"
        :options="{
          active: 'Activate',
          terminated: 'Terminate',
        }"
        :icons="{
          active: 'unlock',
          terminated: 'lock',
        }"
        method="put"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown>
        <DropdownItem label="Edit" icon="edit" :href="route('users.edit', user.id)" />
        <DropdownItem
          label="Delete"
          icon="delete"
          method="delete"
          :href="route('users.destroy', user.id)"
        />
        <DropdownToggleItem
          name="status"
          :value="user.status"
          :href="route('users.update', user.id)"
          :options="{
            active: 'Activate',
            terminated: 'Terminate',
          }"
          :icons="{
            active: 'unlock',
            terminated: 'lock',
          }"
          method="put"
        />
      </Dropdown>
    </template>

    <template #aside>
      <UserCard :user="user" />
    </template>

    <template #content>
      <Card label="Recent tickets.." flush>
        <TicketList :tickets="recentTickets" />
      </Card>
    </template>
  </PageLayout>
</template>
