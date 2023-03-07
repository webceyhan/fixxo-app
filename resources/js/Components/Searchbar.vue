<script setup>
import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Icon from "./Icon.vue";

defineProps({
  filters: Object,
});

const onSearch = ({ target }) => {
  debounce(() => {
    router.get(usePage().url, { search: target.value }, { preserveState: true });
  }, 500)();
};

const onFilter = ({ target }) => {
  router.get(usePage().url, { [target.name]: target.value }, { preserveState: true });
};

// get search params from url
const searchParams = computed(() => {
  // todo: improve this code!
  // usePage is reactive, so we can use it to get the current page params
  // when combined with preserve-state link option
  // location.origin : http://hascom-rma.test'
  // usePage().url:   /customers?status=inactive&key=ca
  const url = location.origin + usePage().url;
  const { searchParams } = new URL(url);

  return [...searchParams.keys()].reduce((acc, key) => {
    acc[key] = searchParams.get(key);
    return acc;
  }, {});
});

// reset search params
const onReset = () => {
  router.get(location.pathname, {}, { preserveState: true });
};

// is dirty
const isDirty = computed(() => {
  return Object.keys(searchParams.value).length > 0;
});
</script>

<template>
  <div class="flex flex-col sm:flex-row items-center-">
    <div class="block relative">
      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <Icon name="search" class="text-gray-500" />
      </span>

      <input
        placeholder="Search"
        type="search"
        :value="searchParams.search"
        class="appearance-none rounded-l border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
        @input="onSearch"
      />
    </div>

    <select
      v-for="(options, key) in filters"
      :key="key"
      :name="key"
      :value="searchParams[key]"
      @change="onFilter"
      class="appearance-none h-full block border-x-0 border-r last:rounded-r bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500"
    >
      <option value="">{{ key }}</option>
      <option v-for="option in options" :key="option" :value="option">
        {{ option }}
      </option>
    </select>

    <SecondaryButton
      v-if="isDirty"
      @click="onReset"
      class="border-l-0 rounded-l-none"
      label="x"
    />
  </div>
</template>
