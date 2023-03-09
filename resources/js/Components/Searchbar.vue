<script setup>
import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Icon from "./Icon.vue";
import BaseInput from "./Base/BaseInput.vue";
import BaseSelect from "./Base/BaseSelect.vue";
import Dropdown from "./Menu/Dropdown.vue";

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
  <div class="flex items-center w-full">
    <div class="flex relative w-full">
      <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <Icon name="search" class="text-xl text-gray-500" />
      </span>

      <!-- expand width of input when search input focused -->
      <BaseInput
        type="search"
        placeholder="Search"
        class="rounded-md rounded-r-none pl-10 w-full"
        :value="searchParams.search"
        @input="onSearch"
        no-rounding
      />
    </div>

    <!-- mobile filters -->
    <Dropdown class="lg:hidden">
      <template #trigger>
        <Icon
          name="filter"
          class="text-xl text-white p-2 hover:bg-gray-800 border border-gray-700 rounded-r-md"
        />
      </template>

      <div class="flex flex-col p-4 space-y-2">
        <BaseSelect
          v-for="(options, key) in filters"
          :key="key"
          :name="key"
          :value="searchParams[key]"
          @change="onFilter"
          class="w-full"
        >
          <option value="">{{ key }}</option>
          <option v-for="option in options" :key="option" :value="option">
            {{ option }}
          </option>
        </BaseSelect>

        <SecondaryButton v-if="isDirty" @click="onReset" label="Clear" />
      </div>
    </Dropdown>

    <BaseSelect
      v-for="(options, key) in filters"
      :key="key"
      :name="key"
      :value="searchParams[key]"
      @change="onFilter"
      class="first:rounded-l-md last:rounded-r-md hidden lg:flex"
      no-rounding
    >
      <option value="">{{ key }}</option>
      <option v-for="option in options" :key="option" :value="option">
        {{ option }}
      </option>
    </BaseSelect>

    <SecondaryButton
      v-if="isDirty"
      @click="onReset"
      class="border-l-0 rounded-l-none hidden lg:flex h-10"
      label="x"
    />
  </div>
</template>
