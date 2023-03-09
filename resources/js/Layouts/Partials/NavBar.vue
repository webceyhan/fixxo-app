<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { MenuButton } from "@headlessui/vue";
import { isAdmin } from "@/Shared/auth";
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";
import Logo from "./Logo.vue";
import NavLink from "./NavLink.vue";
import ResponsiveNavLink from "./ResponsiveNavLink.vue";

const props = defineProps({
  user: Object,
});

const toggled = ref(false);

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
</script>

<template>
  <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="shrink-0 flex items-center">
            <Link :href="route('dashboard')">
              <Logo
                class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
              />
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavLink
              v-for="(link, index) in allowedLinks"
              :key="index"
              :href="route(link.to)"
              :active="route().current(link.to)"
              :class="link.class"
              :label="link.label"
              :icon="link.icon"
            />
          </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <Dropdown>
              <template #trigger>
                <MenuButton
                  class="flex items-center space-x-2 border-0 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                >
                  <p class="text-sm leading-4 font-medium">
                    {{ $page.props.auth.user.name }}
                  </p>

                  <Avatar icon="profile" />
                </MenuButton>
              </template>

              <DropdownItem
                label="Profile"
                icon="profile"
                :href="route('profile.edit')"
              />

              <DropdownItem
                label="Log Out"
                icon="logout"
                method="post"
                :href="route('logout')"
              />
            </Dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="flex items-center sm:hidden">
          <button
            @click="toggled = !toggled"
            class="inline-flex items-center justify-center py-1 px-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
          >
            <Icon name="list" class="text-3xl" />
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
      :class="{
        block: toggled,
        hidden: !toggled,
      }"
      class="sm:hidden"
    >
      <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
          v-for="(link, index) in allowedLinks"
          :key="index"
          :href="route(link.to)"
          :active="route().current(link.to)"
          :class="link.class"
          :label="link.label"
          :icon="link.icon"
        />
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
          <div class="font-medium text-base text-gray-800 dark:text-gray-200">
            {{ $page.props.auth.user.name }}
          </div>
          <div class="font-medium text-sm text-gray-500">
            {{ $page.props.auth.user.email }}
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <ResponsiveNavLink
            label="Profile"
            icon="profile"
            :href="route('profile.edit')"
          />

          <ResponsiveNavLink
            label="Log Out"
            icon="logout"
            method="post"
            as="button"
            :href="route('logout')"
          />
        </div>
      </div>
    </div>
  </nav>
</template>
