<script setup>
import Icon from "@/Components/Icon.vue";
import Avatar from "@/Components/Avatar.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";
import Field from "@/Components/Field.vue";

const notifications = [
  {
    user: "Sara Salah",
    avatarUrl:
      "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80",

    message: "started following you",
    time: "2h",
  },
  {
    user: "Slick Net",
    avatarUrl:
      "https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80",

    message: "liked your post",
    time: "45m",
  },
  {
    user: "Jane Doe",
    avatarUrl:
      "https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80",

    message: "commented on your post",
    time: "1h",
  },
  {
    user: "Abigail Bennett",
    avatarUrl:
      "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=398&q=80",

    message: "started following you",
    time: "3h",
  },
];
</script>

<template>
  <Dropdown align-end wide>
    <template #trigger>
      <button class="btn btn-ghost btn-circle">
        <Icon name="bell" class="text-2xl" />
      </button>
    </template>

    <MenuLink v-for="notification in notifications" :href="route('dashboard')">
      <Avatar :src="notification.avatarUrl" />

      <div>
        <Field :text="notification.user" lead />
        <Field :text="notification.message" alt />
      </div>

      <Field :text="notification.time" alt />
    </MenuLink>
  </Dropdown>
</template>
