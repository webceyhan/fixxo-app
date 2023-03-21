<script setup>
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "@/Shared/utils";
import { useSearchParams } from "@/Shared/routing";
import Icon from "@/Components/Icon.vue";
import Select from "@/Components/Form/Select.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Dropdown from "@/Components/Menu/Dropdown.vue";
import InputGroup from "@/Components/Form/InputGroup.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import RadioGroup from "./Form/RadioGroup.vue";

const props = defineProps({
  filters: Object,
});

const onSearch = ({ target }) => {
  debounce(() => {
    router.reload({
      data: { search: target.value },
      preserveState: true,
    });
  }, 500)();
};

const onFilter = ({ target }) => {
  router.reload({
    data: { [target.name]: target.value },
    preserveState: true,
  });
};

const searchParams = computed(() => {
  return useSearchParams();
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

      <!-- filters -->
      <RadioGroup
        v-for="(options, key) in filters"
        :key="key"
        :name="key"
        :options="options"
        :model-value="searchParams[key]"
        @update:model-value="(value) => onFilter({ target: { name: key, value } })"
        fancy
      />
    </div>

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
            :options="options"
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
    </InputGroup>
  </div>
</template>
