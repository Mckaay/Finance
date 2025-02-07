<script setup>
import BaseField from "@/components/shared/forms/BaseField.vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import { reactive } from "vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import { checkIfObjectHasEmptyProperties } from "@/service/helpers.js";
import { useLoadingStore } from "@/stores/loading.js";
import { useBudgets } from "@/composables/budgets.js";

const budgetService = useBudgets();
const loadingStore = useLoadingStore();

const formData = reactive({
  limit: "",
  category_id: "",
  theme_id: "",
});

const clearFormData = () => {
  formData.limit = "";
  formData.category_id = "";
  formData.theme_id = "";
};

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
  if (!formData.limit || formData.limit < 0) {
    errors.limit = "Limit is required and needs to positive number";
  }

  if (!formData.category_id) {
    errors.category_id = "Category is required";
  }

  if (!formData.theme_id) {
    errors.theme_id = "Theme is required";
  }
};

const emit = defineEmits(["budgetCreated"]);
const saveBudget = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await budgetService.saveBudget({ ...formData });
  clearErrors();
  clearFormData();
  emit("budgetCreated");
};
</script>

<template>
  <form @submit.prevent="saveBudget">
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
        :options="budgetService.state.availableCategories"
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
        :options="budgetService.state.availableThemes"
      />
    </BaseField>
    <BaseButton
      type="submit"
      text="Add New Budget"
      style="width: 100%"
    />
  </form>
</template>
