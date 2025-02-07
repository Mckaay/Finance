<script setup>
import BaseField from "@/components/shared/forms/BaseField.vue";
import ErrorMessage from "@/components/shared/forms/ErrorMessage.vue";
import BaseInput from "@/components/shared/forms/BaseInput.vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import { reactive } from "vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import { checkIfObjectHasEmptyProperties } from "@/service/helpers.js";
import { useLoadingStore } from "@/stores/loading.js";
import { useTransactions } from "@/composables/transactions.js";
import { useCategories } from "@/composables/categories.js";

const transactionService = useTransactions();
const categoriesService = useCategories();

const loadingStore = useLoadingStore();

const formData = reactive({
  name: "",
  date: new Date().toISOString().substring(0, 10),
  category_id: "",
  amount: "",
});

const clearFormData = () => {
  formData.name = "";
  formData.date = new Date().toISOString().substring(0, 10);
  formData.category_id = "";
  formData.amount = "";
};

const errors = reactive({
  name: "",
  date: "",
  category_id: "",
  amount: "",
});

const clearErrors = () => {
  errors.name = "";
  errors.date = "";
  errors.category_id = "";
  errors.amount = "";
};

const validateFormData = () => {
  if (
    formData.name.toString().trim().length === 0 ||
    formData.name.toString().trim().length < 3
  ) {
    errors.name = "Name is required and must be at least 3 characters.";
  }

  if (!formData.category_id) {
    errors.category_id = "Category is required";
  }

  if (!formData.date || new Date(formData.date) >= new Date()) {
    errors.date = "Date is required and can't be in the future";
  }

  if (!formData.amount) {
    errors.amount = "Amount is required";
  }
};

const emit = defineEmits(["transactionCreated"]);

const saveTransaction = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await transactionService.createTransaction({ ...formData });
  emit("transactionCreated");
  clearErrors();
  clearFormData();
};
</script>

<template>
  <ErrorMessage v-if="transactionService.errorMessage">
    {{ transactionService.errorMessage }}
  </ErrorMessage>
  <form @submit.prevent="saveTransaction">
    <BaseField
      id="name"
      label="Name"
      :error="errors.name ?? ''"
    >
      <BaseInput
        v-model="formData.name"
        type="text"
        placeholder="Name of transaction"
        :required="true"
      />
    </BaseField>
    <BaseField
      id="date"
      label="Date"
      :error="errors.date ?? ''"
    >
      <BaseInput
        v-model="formData.date"
        type="date"
        placeholder="Pick a date"
        :required="true"
      />
    </BaseField>
    <BaseField
      id="category"
      label="Category"
      :error="errors.category_id ?? ''"
    >
      <BaseSelect
        v-model="formData.category_id"
        class="select"
        placeholder="Pick category"
        :options="categoriesService.state.list"
      />
    </BaseField>
    <BaseField
      id="amount"
      label="Amount"
      :error="errors.amount ?? ''"
    >
      <InputWithPrefix
        v-model="formData.amount"
        type="number"
        placeholder="0.01"
        :required="true"
        step="0.01"
        pattern="^\d+(?:\.\d{1,2})?$"
      />
    </BaseField>
    <BaseButton
      type="submit"
      text="Add New Transaction"
      style="width: 100%"
    />
  </form>
</template>

<style>
form {
  & .select {
    & ul {
      max-height: 150px;
      overflow-y: scroll;
    }
  }
}
</style>
