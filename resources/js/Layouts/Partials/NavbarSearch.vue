<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import Icon from "@/Components/Icon.vue";

const onSearch = ({ target }: Event) => {
  const search = (target as HTMLInputElement).value;

  // check if route is already customers.index
  if (route().current("customers.index")) {
    // if yes, use router.reload to reload the route
    return debounce(() => {
      router.reload({
        data: { filter: { search } },
      });
    }, 500)();
  }

  // if not, use router.visit to change route and focus on search input
  router.visit(route("customers.index"), {
    preserveScroll: true,
    data: { filter: { search } },
    // bugfix: focus on search input by Vue ref doesn't work
    // because inertia refreshing the page if not on the same route
    // so we use document.getElementById to focus on search input
    // document.getElementById("searchInput").focus();
    onFinish: () => document.getElementById("searchInput")?.focus(),
  });
};
</script>

<template>
  <label
    class="input bg-base-100/50 input-bordered rounded-badge flex items-center gap-2 w-full max-w-md"
  >
    <Icon class="opacity-50" name="search" />

    <input
      id="searchInput"
      type="search"
      class="grow"
      placeholder="Search customers..."
      :value="route().params.filter?.search"
      @input="onSearch"
    />
  </label>
</template>
