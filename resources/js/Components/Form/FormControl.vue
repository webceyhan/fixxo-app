<script>
let index = 0;

export default {
  inheritAttrs: false,
};
</script>

<script setup>
import { ref, useAttrs, computed } from "vue";
import Select from "./Select.vue";
import Textarea from "./Textarea.vue";
import TextInput from "./TextInput.vue";
import Checkbox from "./Checkbox.vue";
import RadioGroup from "./RadioGroup.vue";

const id = `form-control-${index++}`;

const input = ref(null);

const props = defineProps({
  label: String,
  prefix: String,
  suffix: String,
  error: String,
  fancy: Boolean,
});

const attrs = computed(() => ({
  id,
  name: id,
  ...useAttrs(),
}));

defineExpose({
  focus: () => input.value.focus(),
});
</script>

<template>
  <div class="form-control w-full">
    <label v-if="$attrs.type == 'checkbox'" class="label cursor-pointer gap-2">
      <Checkbox ref="input" v-bind="attrs" />
      <span class="label-text mr-auto">{{ label }}</span>
      <slot />
    </label>

    <template v-else>
      <label class="form-control">
        <!-- label -->
        <div class="label">
          <span class="label-text">{{ label }}</span>
        </div>

        <!-- input -->
        <RadioGroup
          v-if="$attrs.options && fancy"
          v-bind="attrs"
          fancy
          ref="input"
          class="w-full"
        />

        <Select v-else-if="$attrs.options" v-bind="attrs" ref="input" />

        <Textarea v-else-if="$attrs.rows" v-bind="attrs" ref="input" />

        <div v-else class="input input-bordered flex items-center gap-2 w-full">
          <span v-if="prefix"> {{ prefix }} </span>

          <TextInput ref="input" v-bind="attrs" embedded />

          <span v-if="suffix"> {{ suffix }} </span>
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
