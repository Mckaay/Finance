<script setup>
import { v4 as uuid } from "uuid";
import BaseLabel from "@/components/shared/forms/BaseLabel.vue";
import HelperMessage from "@/components/shared/forms/HelperMessage.vue";
import { computed, provide } from "vue";
import ErrorMessage from "@/components/shared/forms/ErrorMessage.vue";

defineProps({
  id: {
    type: String,
    default: () => `field-${uuid()}`,
  },
  label: {
    type: String,
    default: () => "",
  },
  error: {
    type: String,
    default: () => "",
  },
  helper: {
    type: String,
    default: () => "",
  },
});

provide(
  "field",
  computed(() => {
    return {
      ...props,
    };
  }),
);
</script>

<template>
  <div class="field-wrapper">
    <BaseLabel v-if="label" :for="props.id">
      {{ label }}
    </BaseLabel>
    <slot />
    <ErrorMessage v-if="props.error">
      {{ error }}
    </ErrorMessage>
    <HelperMessage v-if="props.helper">
      {{ helper }}
    </HelperMessage>
  </div>
</template>

<style scoped>
.field-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-25);
}
</style>
