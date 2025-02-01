<script setup>
import Field from "@/components/shared/forms/Field.vue";
import Select from "@/components/shared/forms/Select.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import {computed, inject, onMounted, reactive, ref} from "vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import {checkIfObjectHasEmptyProperties} from "@/service/helpers.js";
import {useLoadingStore} from "@/stores/loading.js";

const budgetService = inject("budgetService");
const loadingStore = useLoadingStore();

const formData = reactive({
  limit: '',
  category_id: '',
  theme_id: '',
});

const errors = reactive({
  limit: "",
  category_id: "",
  theme_id: "",
})

const clearErrors = () => {
  errors.limit = "";
  errors.category_id = "";
  errors.theme_id = "";
}

const validateFormData = () => {
  if (!formData.limit || formData.limit < 0) {
    errors.limit = "Limit is required and needs to positive number";
  }

  if (!formData.category_id)  {
    errors.category_id = "Category is required";
  }

  if (!formData.theme_id)  {
    errors.theme_id = "Category is required";
  }
}


const emit = defineEmits(['budgetCreated']);
const saveBudget = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await budgetService.saveBudget({...formData})
  clearErrors();
  emit('budgetCreated');
}
</script>

<template>
  <form @submit.prevent="saveBudget">
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
          :options="budgetService.availableCategories.value"
      />
    </Field>
    <Field id="theme" label="Theme" :error="errors.theme_id ?? ''">
      <Select
          v-model="formData.theme_id"
          placeholder="Pick Theme"
          :options="budgetService.availableThemes.value"
      />
    </Field>
    <BaseButton type="submit"  text="Add New Budget" style="width: 100%;"/>
  </form>
</template>

<style lang="scss" scoped>

</style>