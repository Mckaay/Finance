<script setup>
import { useBudgets } from "@/composables/budgets.js";
import { useLoadingStore } from "@/stores/loading.js";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

defineProps({
  id: {
    type: Number,
    default: () => 0,
  },
});

const budgetService = useBudgets();
const loadingStore = useLoadingStore();

const emit = defineEmits(["budgetDeleted"]);
const deleteBudget = async (id) => {
  if (!id) {
    return;
  }

  if (loadingStore.loading) {
    return;
  }

  await budgetService.deleteBudget(id);
  emit("budgetDeleted");
};
</script>

<template>
  <BaseButton
    type="button"
    variant="destroy"
    text="Yes, Confirm Deletion"
    style="width: 100%"
    @click="deleteBudget"
  />
</template>
