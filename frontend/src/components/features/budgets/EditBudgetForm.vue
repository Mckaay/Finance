<script setup>
import BaseField from "@/components/shared/forms/BaseField.vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import { computed, reactive } from "vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import { useLoadingStore } from "@/stores/loading.js";
import { checkIfObjectHasEmptyProperties } from "@/service/helpers.js";
import { useBudgets } from "@/composables/budgets.js";

const budgetService = useBudgets();
const loadingStore = useLoadingStore();

const props = defineProps({
  budget: {
    type: Object,
    default: () => ({
      limit: 0,
      category_id: 0,
      theme_id: 0,
    }),
  },
  availableThemes: {
    type: Array,
    default: () => [],
  },
  availableCategories: {
    type: Array,
    default: () => [],
  },
});

const formData = computed(() => {
  return reactive({
    limit: props.budget.limit,
    category_id: props.budget.category.value,
    theme_id: props.budget.theme.value,
  });
});

const errors = reactive({
  limit: "",
  category_id: "",
  theme_id: "",
});

const clearErrors = () => {
  errors.limit = "";
  errors.category_id = "";
  errors.theme_id = "";
};

const validateFormData = () => {
  if (!formData.value.limit || formData.value.limit < 0) {
    errors.limit = "Limit is required and needs to positive number";
  }

  if (!formData.value.category_id) {
    errors.category_id = "Category is required";
  }

  if (!formData.value.theme_id) {
    errors.theme_id = "Category is required";
  }
};

const emit = defineEmits(["budgetUpdated"]);
const updateBudget = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await budgetService.updateBudget(
    budgetService.state.selectedForEditOrDelete.id,
    { ...formData.value },
  );
  clearErrors();
  emit("budgetUpdated");
};
</script>

<template>
  <form @submit.prevent="updateBudget">
    <BaseField
      id="limit"
      label="Maximum Spend"
      :error="errors.limit ?? ''"
    >
      <InputWithPrefix
        v-model="formData.limit"
        type="number"
        min="1"
        step="1"
        placeholder="e.g. 2000"
        :required="true"
      />
    </BaseField>
    <BaseField
      id="category"
      label="Budget Category"
      :error="errors.category_id ?? ''"
    >
      <BaseSelect
        v-model="formData.category_id"
        placeholder="Pick category"
        :options="availableCategories"
      />
    </BaseField>
    <BaseField
      id="theme"
      label="Theme"
      :error="errors.theme_id ?? ''"
    >
      <BaseSelect
        v-model="formData.theme_id"
        placeholder="Pick Theme"
        :options="availableThemes"
      />
    </BaseField>
    <BaseButton
      type="submit"
      text="Save Changes"
      style="width: 100%"
    />
  </form>
</template>

<style lang="scss" scoped></style>
