<script>
let index = 0;

export default {
  inheritAttrs: false,
  components: { Checkbox, InputGroup, InputGroupText, RadioGroup },
};
</script>

<script setup>
import { ref, useAttrs, computed } from "vue";
import Select from "./Select.vue";
import Textarea from "./Textarea.vue";
import TextInput from "./TextInput.vue";
import InputLabel from "./InputLabel.vue";
import InputError from "./InputError.vue";
import Checkbox from "./Checkbox.vue";
import InputGroup from "./InputGroup.vue";
import InputGroupText from "./InputGroupText.vue";
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
  <div>
    <div v-if="$attrs.type == 'checkbox'" class="flex items-center gap-2">
      <Checkbox ref="input" v-bind="attrs" />
      <InputLabel :for="id" :value="label" />
      <slot />
    </div>

    <template v-else>
      <InputLabel :for="id" :value="label" />

      <RadioGroup
        v-if="$attrs.options && fancy"
        v-bind="attrs"
        fancy
        ref="input"
        class="mt-1 block w-full"
      />

      <Select
        v-else-if="$attrs.options"
        v-bind="attrs"
        ref="input"
        class="mt-1 block w-full"
      />

      <Textarea
        v-else-if="$attrs.rows"
        v-bind="attrs"
        ref="input"
        class="mt-1 block w-full"
      />

      <InputGroup v-else-if="prefix || suffix" class="mt-1 block w-full">
        <InputGroupText v-if="prefix" :value="prefix" />
        <TextInput v-bind="attrs" ref="input" class="w-full"/>
        <InputGroupText v-if="suffix" :value="suffix" />
      </InputGroup>

      <TextInput v-else v-bind="attrs" ref="input" class="mt-1 block w-full" />

      <InputError :message="error" class="mt-2" />
    </template>
  </div>
</template>
