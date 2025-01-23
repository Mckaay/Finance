<script setup>
import Field from "@/components/forms/base/Field.vue";
import Button from "@/components/buttons/Button.vue";
import Select from "@/components/forms/base/Select.vue";
import InputWithPrefix from "@/components/forms/base/InputWithPrefix.vue";
import {computed, onMounted, reactive, ref} from "vue";
import {useBudgets} from "@/composables/budgets.js";

const budgetService = useBudgets();

const props = defineProps({
  id: {
    type: Number,
    default: 0,
  },
  category_id: {
    type: Number,
    default: 0,
  },
  theme_id: {
    type: Number,
    default: 0,
  },
  limit: {
    type: String,
    default: "0",
  },
});

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

const editBudgetForm = computed( () => {
  return reactive({
    limit: props.limit ?? 0,
    category_id: props.category_id ?? 0,
    theme_id: props.theme_id ?? 0,
  });
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

const validateEditBudgetForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(editBudgetForm.value[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const updateBudget = async () => {
  validateEditBudgetForm();

  if (Object.keys(validationErrors.value).length > 0) {
    return;
  }

  await budgetService.updateBudget(props.id,{ ...editBudgetForm.value });
  validationErrors.value = {};
};
</script>

<template>
  <form @submit.prevent="updateBudget">
    <Field id="limit" label="Maximum Spend" :error="validationErrors['limit'] ?? ''">
      <InputWithPrefix
          v-model="editBudgetForm.limit"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <Field id="category" label="Budget Category" :error="validationErrors['category_id'] ?? ''">
      <Select
          v-model="editBudgetForm.category_id"
          type="text"
          placeholder="Pick category"
          :options="availableCategories"
      />
    </Field>
    <Field id="theme" label="Theme" :error="validationErrors['theme_id'] ?? ''">
      <Select
          v-model="editBudgetForm.theme_id"
          type="text"
          placeholder="Pick Theme"
          :options="availableThemes"
      />
    </Field>
    <Button type="submit" class="button-primary" text="Save Changes" style="width: 100%;"/>
  </form>
</template>

<style lang="scss" scoped>

</style>