<script setup lang="ts">
import { computed } from "vue";
import Link from "@/Components/Link.vue";
import Icon from "@/Components/Icon.vue";

type Breadcrumb = { // TODO: extract to shared types
  href?: string;
  label: string;
};

const props = defineProps<{
  links: any[]; // TODO: define type
}>();

const transform = (link: any) =>
  <Breadcrumb>{
    href: link.url,
    label: link.title,
  };

const transformedLinks = computed<Breadcrumb[]>(() => [
  // skip first link (home) and last
  ...props.links.slice(1, -1).map(transform),
  // add last link as label (current page)
  { label: props.links[props.links.length - 1]?.title },
]);
</script>

<template>
  <nav class="flex items-center text-md font-semibold gap-2">
    <Link href="/">
      <Icon name="house" class="text-2xl" />
    </Link>

    <div v-for="{ href, label } in transformedLinks" class="flex items-center gap-2">
      <!-- divider -->
      <Icon name="chevron-right" class="text-sm opacity-50" />

      <!-- link -->
      <Link v-if="href" :href :label />

      <!-- label -->
      <div v-else class="overflow-hidden overflow-ellipsis max-w-sm">
        <span class="truncate" v-html="label" />
      </div>
    </div>
  </nav>
</template>
