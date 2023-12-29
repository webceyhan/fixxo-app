<script setup>
import { formatDate, formatMoney, formatNumber, formatPhone } from "@/Shared/utils";
import Link from "@/Components/Link.vue";

defineProps({
  label: String,
  type: String,
  href: String,
  value: [String, Number],
});
</script>

<template>
  <div class="flex flex-col overflow-hidden gap-1">
    <dt class="text-xs font-semibold tracking-widest uppercase opacity-30">
      <slot name="label"> {{ label }} </slot>
    </dt>

    <dd class="truncate">
      <slot>
        <!-- format as date / datetime -->
        <span v-if="type === 'date'">
          {{ formatDate(value, true) }}
        </span>

        <!-- format as money -->
        <span v-else-if="type === 'money'">
          {{ formatMoney(value) }}
        </span>

        <!-- format as number -->
        <span v-else-if="type === 'number'">
          {{ formatNumber(value) }}
        </span>

        <!-- format as phone number -->
        <Link
          v-else-if="type === 'phone'"
          :label="formatPhone(value)"
          :href="`tel:${value}`"
          outline
          native
        />

        <!-- render as email -->
        <Link
          v-else-if="type === 'email'"
          :label="value"
          :href="`mailto:${value}`"
          outline
          native
        />

        <!-- render as location -->
        <Link
          v-else-if="type === 'location'"
          :label="value"
          :href="`https://www.google.com/maps/place/${value}`"
          target="_blank"
          outline
          native
        />

        <!-- render as link -->
        <Link v-else-if="href" :label="value" :href="href" outline />

        <!-- render as-is -->
        <span v-else> {{ value }} </span>
      </slot>
    </dd>
  </div>
</template>
