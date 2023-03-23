<script setup>
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import UserBadge from "./UserBadge.vue";

defineProps({
  users: Array,
});
</script>

<template>
  <Table>
    <TableRow v-for="user in users" :key="user.id" :href="route('users.show', user.id)">
      <template #avatar>
        <Avatar icon="user" class="opacity-75" />
      </template>

      <template #badge>
        <UserBadge :status="user.status" />
      </template>

      <TableData :value="user.name" :label="user.email" />

      <TableData class="max-lg:hidden capitalize" :value="user.role" label="Role" />

      <TableData class="max-xl:hidden text-end !pr-48" :value="user.assets_count" label="Assets" />

      <TableData class="max-lg:hidden">
        <UserBadge :status="user.status" />
      </TableData>
    </TableRow>
  </Table>
</template>
