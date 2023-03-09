<script setup>
import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import Icon from "@/Components/Icon.vue";
import Select from "@/Components/Form/Select.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import InputGroup from "@/Components/Form/InputGroup.vue";
import BaseButton from "@/Components/Button/BaseButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

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
    <!-- desktop -->
    <InputGroup class="hidden lg:flex relative">
      <!-- search input -->
      <TextInput
        type="search"
        placeholder="Search"
        class="pl-10 flex-1"
        :value="searchParams.search"
        @input="onSearch"
      />

      <!-- search icon overlay -->
      <span class="ignore absolute inset-y-0 left-0 flex items-center pl-3">
        <Icon name="search" class="text-xl text-gray-500" />
      </span>

      <!-- filters -->
      <Select
        v-for="(options, key) in filters"
        :key="key"
        :name="key"
        :value="searchParams[key]"
        @change="onFilter"
      >
        <option value="">{{ key }}</option>
        <option v-for="option in options" :key="option" :value="option">
          {{ option }}
        </option>
      </Select>

      <!-- reset button -->
      <BaseButton
        v-if="isDirty"
        @click="onReset"
        class="w-12 h-auto text-white border-gray-700 hover:bg-gray-700"
        icon="dismiss"
      />
    </InputGroup>

    <!-- mobile -->
    <InputGroup class="flex lg:hidden relative items-center">
      <!-- search input -->
      <TextInput
        type="search"
        placeholder="Search"
        class="pl-10 flex-1"
        :value="searchParams.search"
        @input="onSearch"
      />

      <!-- search icon overlay -->
      <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <Icon name="search" class="text-xl text-gray-500" />
      </span>

      <!-- filters -->
      <Dropdown>
        <template #trigger>
          <Icon
            name="filter"
            class="text-xl text-white hover:bg-gray-800 border border-gray-700 rounded-r-md p-2"
          />
        </template>

        <div class="flex flex-col p-4 space-y-2">
          <Select
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
          </Select>

          <SecondaryButton v-if="isDirty" @click="onReset" label="Clear" />
        </div>
      </Dropdown>
    </InputGroup>
  </div>
</template>
