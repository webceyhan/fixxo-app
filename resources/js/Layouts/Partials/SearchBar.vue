<script setup>
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import { useSearchParams } from "@/Shared/routing";
import Icon from "@/Components/Icon.vue";

const onSearch = ({ target }) => {
  // check if route is already customers.index
  if (route().current("customers.index")) {
    // if yes, use router.reload to reload the route
    return debounce(() => {
      router.reload({
        data: { search: target.value },
        preserveScroll: true,
      });
    }, 500)();
  }

  // if not, use router.visit to change route and focus on search input
  router.visit(route("customers.index"), {
    data: {
      // TODO: improve this on the backend
      // if we don't set status to active, the backend will redirect to customers.index
      // with status:active but ignoring the search query which will result empty input
      status: "active",
      search: target.value,
    },
    onFinish: () => {
      // bugfix: focus on search input by Vue ref doesn't work
      // because inertia refreshing the page if not on the same route
      // so we use document.getElementById to focus on search input
      document.getElementById("searchInput").focus();
    },
    preserveScroll: true,
  });
};
</script>

<template>
  <div class="relative w-full max-w-lg">
    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
      <Icon class="text-xl opacity-50" name="search" />
    </span>

    <input
      id="searchInput"
      type="search"
      class="w-full input pl-12"
      placeholder="Search"
      :value="useSearchParams().search"
      @input="onSearch"
    />
  </div>
</template>
