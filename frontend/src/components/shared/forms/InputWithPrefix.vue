<script setup>
import { inject, useAttrs } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: () => "",
  },
  prefix: {
    type: String,
    default: () => "$",
  },
  placeholder: {
    type: [String],
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
  <div class="input-prefix-container">
    <span class="prefix">{{ prefix }}</span>
    <input
      :id="field.id"
      :value="props.modelValue"
      class="input"
      :placeholder="placeholder"
      :required="required"
      v-bind="attrs"
      @input="($event) => emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<style scoped>
.input-prefix-container {
  display: flex;
  align-items: center;
  color: var(--clr-grey-900);
  font-size: var(--fs-87);
  position: relative;

  & .input {
    padding: var(--spacing-75) var(--spacing-75) var(--spacing-75)
      var(--spacing-250);
  }

  & span {
    display: block;
    position: absolute;
    left: var(--spacing-125);
  }
}

.input-prefix-container:hover {
  color: var(--clr-grey-900);
}
</style>
