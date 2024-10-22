<script setup lang="ts">
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import { useSearchParams } from "@/Shared/routing";
import Icon from "@/Components/Icon.vue";
import Select from "@/Components/Form/Select.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import DropdownTrigger from "./Menu/DropdownTrigger.vue";
import MenuSection from "./Menu/MenuSection.vue";
import MenuLink from "@/Components/Menu/MenuLink.vue";
import RadioGroup from "./Form/RadioGroup.vue";

type FilterParams = {
  // TODO: extract to shared types
  [key: string]: string;
  search: string;
};

type FilterEvent = {
  // TODO: extract to shared types
  target: {
    name?: string;
    value: any;
  };
};

const props = defineProps<{
  // TODO: extract to shared types
  filters: Record<string, { default: string; options: string[] }>;
}>();

const sortOptions = [
  { label: "Newest", value: "-created_at" },
  { label: "Oldest", value: "created_at" },
];

const onSort = ({ target }: FilterEvent) => {
  router.reload({
    data: {
      sort: target.value,
      page: 1, // reset pagination
    },
  });
};

const onSearch = ({ target }: FilterEvent) => {
  debounce(() => {
    router.reload({
      data: {
        filter: { search: target.value },
        page: 1, // reset pagination
      },
    });
  }, 500)();
};

const onFilter = ({ target }: FilterEvent) => {
  router.reload({
    data: {
      filter: { [target.name!]: target.value },
      page: 1, // reset pagination
    },
  });
};

const sortParam = computed(() => {
  const params = useSearchParams();
  return params.sort ?? sortOptions[0].value;
});

const searchParams = computed<FilterParams>(() => {
  const params = useSearchParams();
  const keys = [...Object.keys(props.filters), "search"];

  // fetch value from wrapped filter object
  const valueOf = (key: string) => params[`filter[${key}]`];

  // convert { filter[key]: value } to { key: value }
  return keys.reduce((acc, key) => ({ ...acc, [key]: valueOf(key) }), {} as any);
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
        v-for="(filter, name) in filters"
        :name
        :options="filter.options"
        :model-value="searchParams[name] ?? filter.default"
        @update:model-value="(value) => onFilter({ target: { name, value } })"
        fancy
      />
    </div>

    <!-- mobile -->
    <div class="flex lg:hidden w-full gap-2">
      <!-- search input -->
      <div class="relative inline-flex w-full h-10">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
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
      <Dropdown align-end>
        <template #trigger>
          <DropdownTrigger class="border-base-content/20 min-h-10 h-auto">
            <Icon name="sort" class="text-xl" />
          </DropdownTrigger>
        </template>

        <MenuLink
          v-for="option in sortOptions"
          :key="option.value"
          :value="option.value"
          :label="option.label"
          @click="onSort({ target: { value: option.value } })"
        />
      </Dropdown>

      <!-- filters -->
      <Dropdown align-end>
        <template #trigger>
          <DropdownTrigger class="border-base-content/20 min-h-10 h-auto">
            <Icon name="filter" class="text-xl" />
          </DropdownTrigger>
        </template>

        <MenuSection v-for="(filter, name) in filters" :title="name">
          <MenuLink
            v-for="value in filter.options"
            @click.prevent="onFilter({ target: { name, value } })"
          >
            {{ value }}

            <Icon
              v-if="searchParams[name] === value"
              class="ml-auto"
              name="dismiss"
              @click.stop="onReset"
            />
          </MenuLink>
        </MenuSection>
      </Dropdown>
    </div>
  </div>
</template>
