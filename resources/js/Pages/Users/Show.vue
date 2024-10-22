<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";
import TicketList from "@/Pages/Tickets/Partials/TicketList.vue";
import UserCard from "./Partials/UserCard.vue";

const props = defineProps({
  user: Object,
  recentTickets: Array,
});

const NEXT_STATUS = {
  active: {
    label: "Terminate",
    icon: "lock",
    data: { status: "terminated" },
  },
  terminated: {
    label: "Activate",
    icon: "unlock",
    data: { status: "active" },
  },
};
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
      <SecondaryButton
        method="put"
        :href="route('users.update', user.id)"
        v-bind="NEXT_STATUS[user.status]"
      />
    </template>

    <!-- mobile menu -->
    <template #mobile-menu>
      <Dropdown align-end>
        <MenuLink label="Edit" icon="edit" :href="route('users.edit', user.id)" />
        <MenuLink
          label="Delete"
          icon="delete"
          method="delete"
          :href="route('users.destroy', user.id)"
        />
        <MenuLink
          method="put"
          :href="route('users.update', user.id)"
          v-bind="NEXT_STATUS[user.status]"
        />
      </Dropdown>
    </template>

    <template #aside>
      <UserCard :user="user" />
    </template>

    <template #content>
      <Card title="Recent tickets.." flush>
        <TicketList :tickets="recentTickets" />
      </Card>
    </template>
  </PageLayout>
</template>
