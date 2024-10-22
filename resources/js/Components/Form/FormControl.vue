<script setup lang="ts">
import { ref } from "vue";
import Select from "./Select.vue";
import Textarea from "./Textarea.vue";
import TextInput from "./TextInput.vue";
import Checkbox from "./Checkbox.vue";
import RadioGroup from "./RadioGroup.vue";

defineOptions({
  inheritAttrs: false,
});

defineProps<{
  label?: string;
  type?: string;
  prefix?: string;
  suffix?: string;
  error?: string;
  fancy?: boolean;
}>();

const input = ref<HTMLElement | null>(null);

defineExpose({
  focus: () => input.value?.focus(),
});
</script>

<template>
  <div class="form-control w-full">
    <template v-if="type == 'checkbox'">
      <label class="label cursor-pointer gap-2">
        <Checkbox ref="input" v-bind="$attrs" />
        <span class="label-text mr-auto" v-html="label" />
        <slot />
      </label>
    </template>

    <template v-else>
      <label class="form-control">
        <!-- label -->
        <div class="label">
          <span class="label-text" v-html="label" />
        </div>

        <!-- input -->
        <RadioGroup
          v-if="$attrs.options && fancy"
          ref="input"
          class="w-full"
          v-bind="$attrs"
          fancy
        />

        <Select v-else-if="$attrs.options" ref="input" v-bind="$attrs" />

        <Textarea v-else-if="$attrs.rows" ref="input" v-bind="$attrs" />

        <div v-else class="input input-bordered flex items-center gap-2 w-full">
          <span v-if="prefix" v-html="prefix" />

          <TextInput ref="input" v-bind="{ ...$attrs, type }" embedded />

          <span v-if="suffix" v-html="suffix" />
        </div>

        <!-- error -->
        <div class="label" v-if="$slots.error || error">
          <div class="label-text-alt text-error">
            <slot name="error"> {{ error }} </slot>
          </div>
        </div>
      </label>
    </template>
  </div>
</template>
