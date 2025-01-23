<script setup>
import Modal from "@/components/modals/Modal.vue";
import Select from "@/components/forms/base/Select.vue";
import Field from "@/components/forms/base/Field.vue";
import Button from "@/components/buttons/Button.vue";
import Input from "@/components/forms/base/Input.vue";
import {reactive, ref, useTemplateRef} from "vue";
import {useTransactions} from "@/composables/transactions.js";
import ErrorMessage from "@/components/forms/base/ErrorMessage.vue";

const props = defineProps(['categories']);

const modalRef = useTemplateRef('modal');
const openModal = () => {
  modalRef.value.openModal();
}

defineExpose({
  openModal,
})

const transactionService = useTransactions();

const addTransactionForm = reactive({
  name: '',
  date: '',
  category_id: '',
  amount: '',
});

const validationErrors = ref({});
const validationRules = {
  name: (value) => {
    if (!value || value.length < 3) {
      return "Name is required and should be at least 3 characters long";
    }
  },
  date: (value) => {
    if (!value || new Date(value) > new Date()) {
      return "Date is required and must be in the past";
    }
  },
  category_id: (value) => {
    if (!value) {
      return "Category is required";
    }
  },
  amount: (value) => {
    if (!value) {
      return "Amount is required";
    }
  },
};

const validateAddTransactionForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(addTransactionForm[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const emit = defineEmits(['transactionCreated']);
const saveTransaction = async () => {
  validateAddTransactionForm();

  if (Object.keys(validationErrors.value).length > 0) {
    return;
  }

  await transactionService.saveTransaction({ ...addTransactionForm });
  validationErrors.value = {};
  emit('transactionCreated');
};
</script>

<template>
  <Modal
      ref="modal"
      modalHeader="Add New Transaction"
      modalDescription="Create transactions to manage, control your spendings and incomes."
  >
    <ErrorMessage v-if="transactionService.errorMessage">
      {{ transactionService.errorMessage }}
    </ErrorMessage>
    <form @submit.prevent="saveTransaction">
      <Field id="name" label="Name" :error="validationErrors['name'] ?? ''">
        <Input
            v-model="addTransactionForm.name"
            type="text"
            placeholder="Name of transaction"
            :required="true"
        />
      </Field>
      <Field id="date" label="Date" :error="validationErrors['date'] ?? ''">
        <Input
            v-model="addTransactionForm.date"
            type="date"
            placeholder="Pick a date"
            :required="true"
        />
      </Field>
      <Field id="category" label="Category" :error="validationErrors['category_id'] ?? ''">
        <Select
            v-model="addTransactionForm.category_id"
            type="text"
            placeholder="Pick category"
            :options="props.categories"
        />
      </Field>
      <Field id="amount" label="Amount" :error="validationErrors['amount'] ?? ''">
        <Input
            v-model="addTransactionForm.amount"
            type="number"
            placeholder="0.001"
            :required="true"
        />
      </Field>
      <Button type="submit" class="button-primary" text="Add New Transaction" style="width: 100%;"/>
    </form>
  </Modal>
</template>

<style lang="scss" scoped>

</style>