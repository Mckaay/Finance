<script setup>
const props = defineProps({
  for: {
    type: String,
    default: () => "",
  },
});
</script>

<template>
  <label :for="props.for">
    <slot />
  </label>
</template>

<style scoped>
label {
  font-size: var(--fs-80);
  font-weight: var(--fw-700);
  color: var(--clr-grey-500);
  line-height: 1.5;
}
</style>
