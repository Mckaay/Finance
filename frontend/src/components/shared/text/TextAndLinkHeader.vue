<script setup>
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

const props = defineProps({
  text: {
    type: String,
    default: "",
  },
  linkText: {
    type: String,
    default: "",
  },
  routeName: {
    type: String,
    default: "",
  }
})
</script>

<template>
  <div class="text-and-link-header">
    <h3>{{ text }}</h3>
    <router-link class="link" :to="{ name: props.routeName }">
      <BaseButton variant="tertiary" :text="linkText"/>
    </router-link>
  </div>
</template>

<style scoped>
.text-and-link-header {
  display: flex;
  justify-content: space-between;

  & .link {
    all: unset;
  }
}

.text-and-link-header > h3 {
  font-size: var(--fs-100);
  font-weight: var(--fw-700);
}
</style>