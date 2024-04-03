<script setup>
import { computed } from "vue";
import { isAdmin } from "@/Shared/auth";
import SidebarLink from "./SidebarLink.vue";
import Logo from "./Logo.vue";

const emit = defineEmits(["update:toggled"]);

const props = defineProps({
  toggled: Boolean,
  notificationOpen: Boolean,
});

const links = [
  {
    label: "New",
    icon: "create",
    to: "customers.create",
  },
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
    label: "Invoices",
    icon: "invoice",
    to: "invoices.index",
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
    label: "Users",
    icon: "user",
    to: "users.index",
    // class: "hidden md:inline-flex",
    admin: true,
  },
];

const allowedLinks = computed(() =>
  links.filter(({ admin }) => !(admin && !isAdmin.value))
);

const proxyToggled = computed({
  get: () => props.toggled,
  set: (val) => emit("update:toggled", val),
});
</script>

<template>
  <div
    :class="proxyToggled ? 'block' : 'hidden'"
    @click="proxyToggled = false"
    class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"
  />

  <Transition>
    <div
      :class="{
        // base
        'fixed inset-y-0 left-0 lg:static lg:inset-0 z-30 w-60 overflow-y-auto': true,
        // background
        'bg-gray-900 dark:bg-black border-r border-gray-800': true,
        // toggle state
        'transition duration-300 transform lg:translate-x-0': true,
        'translate-x-0 ease-out': proxyToggled,
        '-translate-x-full ease-in': !proxyToggled,
      }"
    >
      <!-- Logo -->
      <header class="flex items-center mt-3 px-6 py-2">
        <Logo class="block h-9 w-auto fill-current text-white mr-4" />
        <span class="text-2xl font-semibold text-white">Fixxo</span>
      </header>

      <!-- Navigation Links -->
      <nav class="mt-8">
        <SidebarLink
          v-for="(link, index) in allowedLinks"
          :key="index"
          :href="route(link.to)"
          :active="route().current(link.to)"
          :class="link.class"
          :label="link.label"
          :icon="link.icon"
        />
      </nav>
    </div>
  </Transition>
</template>
