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
    label: "Assets",
    icon: "asset",
    to: "assets.index",
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
  ></div>

  <Transition>
    <div
      class="fixed inset-y-0 left-0 z-30 w-60 overflow-y-auto transition duration-300 transform bg-gray-900 dark:bg-black/50 lg:translate-x-0 lg:static lg:inset-0"
      :class="proxyToggled ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    >
      <!-- Logo -->
      <header class="mt-4 px-6">
        <Logo class="w-12 h-12" />
      </header>

      <!-- Navigation Links -->
      <nav>
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
