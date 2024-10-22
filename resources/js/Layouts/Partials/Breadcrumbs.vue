<script setup>
import { computed } from "vue";
import Link from "@/Components/Link.vue";
import Icon from "@/Components/Icon.vue";

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
      <Icon name="house" class="text-2xl" />
    </Link>

    <div
      v-for="(link, index) in transformedLinks"
      :key="index"
      class="flex items-center gap-2"
    >
      <!-- divider -->
      <Icon name="chevron-right" class="text-sm opacity-50" />

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
