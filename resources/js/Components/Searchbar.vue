<script setup>
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import { useSearchParams } from "@/Shared/routing";
import Icon from "@/Components/Icon.vue";
import Select from "@/Components/Form/Select.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DrowdownItem from "@/Components/Menu/DropdownItem.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import RadioGroup from "./Form/RadioGroup.vue";

const props = defineProps({
  filters: Object,
});

const sortOptions = [
  { label: "Newest", value: "-created_at" },
  { label: "Oldest", value: "created_at" },
];

const onSort = ({ target }) => {
  router.reload({
    data: {
      sort: target.value,
      page: 1, // reset pagination
    },
    preserveState: true,
  });
};

const onSearch = ({ target }) => {
  debounce(() => {
    router.reload({
      data: {
        filter: { search: target.value },
        page: 1, // reset pagination
      },
      preserveState: true,
    });
  }, 500)();
};

const onFilter = ({ target }) => {
  router.reload({
    data: {
      filter: { [target.name]: target.value },
      page: 1, // reset pagination
    },
    preserveState: true,
  });
};

const sortParam = computed(() => {
  const params = useSearchParams();
  return params.sort ?? sortOptions[0].value;
});

const searchParams = computed(() => {
  const params = useSearchParams();
  const keys = [...Object.keys(props.filters), "search"];

  // fetch value from wrapped filter object
  const valueOf = (key) => params[`filter[${key}]`];

  // convert { filter[key]: value } to { key: value }
  return keys.reduce((acc, key) => ({ ...acc, [key]: valueOf(key) }), {});
});

const isDirty = computed(() => {
  return Object.keys(useSearchParams()).length > 0;
});

const onReset = () => {
  router.get(location.pathname, {}, { preserveState: true });
};
</script>

<template>
  <div class="flex items-center w-full">
    <!-- desktop -->
    <div class="hidden lg:flex items-stretch gap-4 w-full">
      <!-- search input -->
      <div class="w-full relative">
        <span class="ignore absolute inset-y-0 left-0 flex items-center pl-3">
          <Icon name="search" class="text-xl text-gray-500" />
        </span>

        <TextInput
          type="search"
          placeholder="Search"
          class="text-sm font-semibold pl-10 h-full w-full"
          :value="searchParams.search"
          @input="onSearch"
        />
      </div>

      <!-- sorts -->
      <Select :options="sortOptions" :value="sortParam" @change="onSort" />

      <!-- filters -->
      <RadioGroup
        v-for="(filter, key) in filters"
        :key="key"
        :name="key"
        :options="filter.options"
        :model-value="searchParams[key] ?? filter.default"
        @update:model-value="(value) => onFilter({ target: { name: key, value } })"
        fancy
      />
    </div>

    <!-- mobile -->
    <div class="flex lg:hidden w-full">
      <!-- search input -->
      <div class="relative inline-flex w-full h-10">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          <Icon name="search" class="text-xl text-gray-500" />
        </span>

        <TextInput
          type="search"
          placeholder="Search"
          class="text-sm font-semibold pl-10 h-full w-full rounded-r-none"
          :value="searchParams.search"
          @input="onSearch"
        />
      </div>

      <!-- sorts -->
      <Dropdown trigger-class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 px-2">
        <template #trigger>
          <Icon name="sort" class="text-xl dark:text-gray-300" />
        </template>

        <DrowdownItem
          v-for="option in sortOptions"
          :key="option.value"
          :value="option.value"
          :label="option.label"
          @click="onSort({ target: { value: option.value } })"
        />
      </Dropdown>

      <!-- filters -->
      <Dropdown trigger-class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 px-2 rounded-r-md">
        <template #trigger>
          <Icon name="filter" class="text-xl dark:text-gray-300" />
        </template>

        <div class="flex flex-col p-4 space-y-2">
          <Select
            v-for="(filter, key) in filters"
            :key="key"
            :name="key"
            :value="searchParams[key] ?? filter.default"
            :options="filter.options"
            @change="onFilter"
            class="w-full"
          >
            <template #header>
              <option value="" disabled>{{ key }}</option>
            </template>
          </Select>

          <SecondaryButton v-if="isDirty" @click="onReset" label="Clear" />
        </div>
      </Dropdown>
    </div>
  </div>
</template>
