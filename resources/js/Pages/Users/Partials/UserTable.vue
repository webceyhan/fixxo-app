<script setup>
import { formatDate } from "@/Shared/utils";
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
        <UserBadge :status="user.status" compact />
      </template>

      <TableData :value="user.name" :label="user.role" />

      <TableData class="max-2xl:hidden" :label="user.email" :value="user.phone" />

      <TableData
        class="max-xl:hidden text-end"
        :value="user.tickets_count"
        label="Tickets"
      />

      <TableData class="max-lg:hidden text-end">
        <UserBadge :status="user.status" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <template #label>
          {{ formatDate(user.created_at) }}
        </template>
      </TableData>
    </TableRow>
  </Table>
</template>
