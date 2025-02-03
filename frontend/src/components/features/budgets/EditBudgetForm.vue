<script setup>
import Field from "@/components/shared/forms/Field.vue";
import Select from "@/components/shared/forms/Select.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import {computed, inject, reactive} from "vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import {useLoadingStore} from "@/stores/loading.js";
import {checkIfObjectHasEmptyProperties} from "@/service/helpers.js";
import {useBudgets} from "@/composables/budgets.js";

const budgetService = useBudgets()
const loadingStore = useLoadingStore();

const formData = computed(() => {
  return reactive({
    limit: budgetService.state.selectedForEditOrDelete.limit ?? 0,
    category_id: budgetService.state.selectedForEditOrDelete.category.value ?? 0,
    theme_id: budgetService.state.selectedForEditOrDelete.theme.value ?? 0,
  })
})

const errors = reactive({
  limit: "",
  category_id: "",
  theme_id: "",
});

const clearErrors = () => {
  errors.limit = "";
  errors.category_id = "";
  errors.theme_id = "";
}

const validateFormData = () => {

  if (!formData.value.limit || formData.value.limit < 0) {
    errors.limit = "Limit is required and needs to positive number";

    console.log('Im here');
  }

  if (!formData.value.category_id) {
    errors.category_id = "Category is required";
  }

  if (!formData.value.theme_id) {
    errors.theme_id = "Category is required";
  }
}


const emit = defineEmits(['budgetUpdated']);
const updateBudget = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await budgetService.updateBudget(budgetService.state.selectedForEditOrDelete.id, {...formData.value})
  clearErrors();
  emit('budgetUpdated');
}
</script>

<template>
  <form @submit.prevent="updateBudget">
    <Field id="limit" label="Maximum Spend" :error="errors.limit ?? ''">
      <InputWithPrefix
          v-model="formData.limit"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <Field id="category" label="Budget Category" :error="errors.category_id ?? ''">
      <Select
          v-model="formData.category_id"
          placeholder="Pick category"
          :options="budgetService.state.availableCategories"
      />
    </Field>
    <Field id="theme" label="Theme" :error="errors.theme_id ?? ''">
      <Select
          v-model="formData.theme_id"
          placeholder="Pick Theme"
          :options="budgetService.state.availableThemes"
      />
    </Field>
    <BaseButton type="submit" text="Save Changes" style="width: 100%;"/>
  </form>
</template>

<style lang="scss" scoped>

</style>