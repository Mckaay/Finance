<script setup>
const props = defineProps({
  color: {
    type: String,
    default: "#000",
  },
});
</script>

<template>
  <div class="circle" />
</template>

<style scoped>
.circle {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background-color: v-bind("props.color");
}
</style>
