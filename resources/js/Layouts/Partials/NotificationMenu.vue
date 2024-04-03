<script setup>
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownItem from "@/Components/Menu/DropdownItem.vue";

const notifications = [
  {
    user: {
      name: "Sara Salah",
      avatar:
        "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80",
    },
    message: "started following you",
    time: "2h",
  },
  {
    user: {
      name: "Slick Net",
      avatar:
        "https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80",
    },
    message: "liked your post",
    time: "45m",
  },
  {
    user: {
      name: "Jane Doe",
      avatar:
        "https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80",
    },
    message: "commented on your post",
    time: "1h",
  },
  {
    user: {
      name: "Abigail Bennett",
      avatar:
        "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=398&q=80",
    },
    message: "started following you",
    time: "3h",
  },
];
</script>

<template>
  <Dropdown wide>
    <template #trigger>
    <Avatar icon="bell" class="dark:text-white/50 dark:hover:text-white" />
    </template>

    <DropdownItem
      v-for="(notification, i) in notifications"
      :key="i"
      :href="route('dashboard')"
      class="text-left"
    >
      <Avatar :src="notification.user.avatar" class="flex-shrink-0 !w-10 !h-10" />

      <p class="w-full text-sm space-x-2">
        <span class="font-semibold">
          {{ notification.user.name }}
        </span>
        <span class="text-sm">
          {{ notification.message }}
        </span>
        <span class="text-xs opacity-50">
          {{ notification.time }}
        </span>
      </p>
    </DropdownItem>
  </Dropdown>
</template>
