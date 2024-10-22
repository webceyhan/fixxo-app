<script setup lang="ts">
import { computed } from "vue";
import { isAdmin } from "@/Shared/auth";
import Menu from "@/Components/Menu/Menu.vue";
import Divider from "@/Components/Divider.vue";
import MenuSection from "@/Components/Menu/MenuSection.vue";
import SidebarLink from "./SidebarLink.vue";
import Logo from "./Logo.vue";

type SideLink = {
  // TODO: extract to shared types
  label?: string;
  icon?: string;
  to?: string;
  admin?: boolean;
};

const links: SideLink[] = [
  {
    label: "New",
    icon: "create",
    to: "customers.create",
  },
  {},
  {
    label: "Dashboard",
    icon: "dashboard",
    to: "dashboard",
    admin: true,
  },
  {
    label: "Customers",
    icon: "customer",
    to: "customers.index",
  },
  {
    label: "Tickets",
    icon: "ticket",
    to: "tickets.index",
  },
  {
    label: "Inventory",
  },
  {
    label: "Devices",
    icon: "device",
    to: "devices.index",
  },
  {
    label: "Orders",
    icon: "order",
    to: "orders.index",
  },
  {
    label: "Backoffice",
  },
  {
    label: "Users",
    icon: "user",
    to: "users.index",
    admin: true,
  },
  {
    label: "Invoices",
    icon: "invoice",
    to: "invoices.index",
  },
];

const allowedLinks = computed(() =>
  links.filter(({ admin }) => !(admin && !isAdmin.value))
);
</script>

<template>
  <div class="inset w-60 bg-base-300 min-h-full">
    <!-- Logo -->
    <header class="flex items-center px-6 py-4 gap-4">
      <Logo class="block h-9 w-auto fill-current" />
      <span class="text-2xl font-semibold">Fixxo</span>
    </header>

    <!-- Navigation Links -->
    <Menu class="!bg-transparent mt-7 p-0">
      <template v-for="{ to, label, icon } in allowedLinks">
        <SidebarLink
          v-if="to"
          :href="route(to)"
          :active="route().current(to)"
          :label
          :icon
        />

        <MenuSection v-else-if="label" :title="label" class="px-2 mt-6" />

        <Divider v-else class="opacity-20" />
      </template>
    </Menu>
  </div>
</template>
