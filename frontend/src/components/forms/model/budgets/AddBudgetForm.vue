<script setup>
import Field from "@/components/forms/base/Field.vue";
import Button from "@/components/buttons/Button.vue";
import Select from "@/components/forms/base/Select.vue";
import InputWithPrefix from "@/components/forms/base/InputWithPrefix.vue";
import {computed, onMounted, reactive, ref} from "vue";
import {useBudgets} from "@/composables/budgets.js";

const budgetService = useBudgets();

onMounted(async () => {
  await budgetService.fetchAvailableOptions();
})

const availableCategories = computed(() => {
  const categories = budgetService?.availableOptions?.value?.categories || [];
  return categories.map((category) => {
    return {
      value: category.id,
      label: category.name,
      disabled: category.disabled,
    }
  })
});

const availableThemes = computed(() => {
  const themes = budgetService?.availableOptions?.value?.themes || [];
  return themes.map((theme) => {
    return {
      value: theme.id,
      label: theme.name,
      disabled: theme.disabled,
    }
  })
});

const addBudgetForm = reactive({
  limit: '',
  category_id: '',
  theme_id: '',
});

const validationErrors = ref({});
const validationRules = {
  category_id: (value) => {
    if (!value) {
      return "Category is required";
    }
  },
  theme_id: (value) => {
    if (!value) {
      return "Theme is required";
    }
  },
  limit: (value) => {
    if (!value || (value < 0)) {
      return "Maximum spend is required";
    }
  },
};

const validateAddBudgetForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(addBudgetForm[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const saveBudget = async () => {
  validateAddBudgetForm();

  if (Object.keys(validationErrors.value).length > 0) {
    return;
  }

  await budgetService.saveBudget({ ...addBudgetForm });
  validationErrors.value = {};
};
</script>

<template>
  <form @submit.prevent="saveBudget">
    <Field id="limit" label="Maximum Spend" :error="validationErrors['limit'] ?? ''">
      <InputWithPrefix
          v-model="addBudgetForm.limit"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <Field id="category" label="Budget Category" :error="validationErrors['category_id'] ?? ''">
      <Select
          v-model="addBudgetForm.category_id"
          type="text"
          placeholder="Pick category"
          :options="availableCategories"
      />
    </Field>
    <Field id="theme" label="Theme" :error="validationErrors['theme_id'] ?? ''">
      <Select
          v-model="addBudgetForm.theme_id"
          type="text"
          placeholder="Pick Theme"
          :options="availableThemes"
      />
    </Field>
    <Button type="submit" class="button-primary" text="Add New Budget" style="width: 100%;"/>
  </form>
</template>

<style lang="scss" scoped>

</style>