<script setup>
defineProps({
  width: {
    type: String,
    default: "100%",
  },
  color: {
    type: String,
    default: "#000",
  },
});
</script>

<template>
  <div class="progress-bar" />
</template>

<style scoped>
.progress-bar {
  --progress-bar-height: var(--spacing-200);
  border-radius: var(--spacing-25);
  background-color: var(--clr-beige-100);
  padding: var(--spacing-25);
  height: var(--progress-bar-height);
}

.progress-bar::before {
  display: block;
  content: "";
  height: calc(var(--progress-bar-height) - (var(--spacing-25) * 2));
  background-color: v-bind("props.color");
  border-radius: var(--spacing-25);
  width: v-bind("props.width");
}
</style>
