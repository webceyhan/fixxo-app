<script setup lang="ts">
import { formatDate } from "@/Shared/utils";
import Avatar from "@/Components/Avatar.vue";
import Table from "@/Components/Table/Table.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableData from "@/Components/Table/TableData.vue";
import UserBadge from "./UserBadge.vue";

defineProps<{
  users: any[]; // TODO: define User type
}>();
</script>

<template>
  <Table>
    <TableRow v-for="user in users" :href="route('users.show', user.id)">
      <TableData class="w-8 pe-0 align-top">
        <Avatar class="max-sm:hidden opacity-75" icon="user" />
        <UserBadge class="sm:hidden" :status="user.status" compact />
      </TableData>

      <TableData>
        <p class="text-lead">{{ user.name }}</p>
        <p class="text-alt titlecase">{{ user.role }}</p>
      </TableData>

      <TableData class="max-2xl:hidden">
        <p>{{ user.email }}</p>
        <p class="text-alt">{{ user.phone }}</p>
      </TableData>

      <TableData class="max-xl:hidden">
        <p>{{ user.assigned_tickets_count }}</p>
        <p class="text-alt">Tickets</p>
      </TableData>

      <TableData class="max-lg:hidden">
        <UserBadge :status="user.status" />
      </TableData>

      <TableData class="max-lg:hidden text-end">
        <p class="text-alt">{{ formatDate(user.created_at) }}</p>
      </TableData>
    </TableRow>
  </Table>
</template>
