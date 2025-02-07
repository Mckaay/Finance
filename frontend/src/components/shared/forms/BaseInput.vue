<script setup>
import { inject, useAttrs } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: () => "",
  },
  required: {
    type: [Boolean],
    default: () => false,
  },
});
const attrs = useAttrs();

const emit = defineEmits(["update:modelValue"]);
const field = inject("field");
</script>

<template>
  <input
    :id="field.id"
    type="text"
    :value="props.modelValue"
    class="input"
    :required="required"
    v-bind="attrs"
    @input="($event) => emit('update:modelValue', $event.target.value)"
  />
</template>

<style>
.input {
  font-size: var(--fs-87);
  color: var(--clr-grey-900);
  padding: var(--spacing-75) var(--spacing-125);
  width: 100%;
  border-radius: var(--spacing-50);
  border: 1px solid var(--clr-beige-500);
}

.input:hover {
  border: 1px solid var(--clr-grey-500);
}

.input:focus {
  color: var(--clr-grey-900);
  outline: none;
  border: 1px solid var(--clr-grey-900);
}

.input::placeholder {
  color: var(--clr-beige-500);
}

.input:hover::placeholder {
  color: var(--clr-grey-900);
}
</style>
