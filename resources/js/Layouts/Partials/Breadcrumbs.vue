<script setup>
import { computed } from "vue";
import Link from "@/Components/Link.vue";

const props = defineProps({
  links: Array,
});

const transform = (link) => ({
  href: link.url,
  label: link.title,
});

const transformedLinks = computed(() => [
  // skip first link (home) and last
  ...props.links.slice(1, -1).map(transform),
  // add last link as label (current page)
  { label: props.links[props.links.length - 1]?.title },
]);
</script>

<template>
  <nav
    class="flex items-center text-md font-semibold text-gray-400 dark:text-white gap-2"
  >
    <Link href="/">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6 -mt-1"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
        />
      </svg>
    </Link>

    <div
      v-for="(link, index) in transformedLinks"
      :key="index"
      class="flex items-center gap-2"
    >
      <!-- divider -->
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-4 h-4"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M8.25 4.5l7.5 7.5-7.5 7.5"
        />
      </svg>

      <!-- link -->
      <Link v-if="link.href" :href="link.href" :label="link.label" />

      <!-- label -->
      <div v-else class="overflow-hidden overflow-ellipsis max-w-sm">
        <span class="truncate">
          {{ link.label }}
        </span>
      </div>
    </div>
  </nav>
</template>
