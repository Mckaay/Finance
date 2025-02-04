<script setup>
import Field from "@/components/shared/forms/Field.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import {reactive, ref, watch} from "vue";
import {usePotTransactions} from "@/composables/potTransactions.js";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import {checkIfObjectHasEmptyProperties} from "@/service/helpers.js";

const props = defineProps({
  potId: {
    type: Number,
    default: 0,
  },
  type: {
    type: String,
    default: 'deposit',
  },
  submitButtonText: {
    type: String,
    default: "Submit",
  },
});

const potTransactionService = usePotTransactions();

const formData = reactive({
  amount: 0,
  type: props.type ?? 'deposit',
})

const clearFormData = () => {
  formData.amount = 0;
  formData.type = props.type ?? 'deposit';
}

const errors = reactive({
  amount: '',
})

const validateFormData = () => {
  if (!formData.amount || formData.amount < 0) {
    errors.amount =  "Amount is required and needs to be positive number";
  }
}

const savePotTransaction = async () => {
  validateFormData();
  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }
  
  await potTransactionService.savePotTransaction({ ...formData, pot_id: props.potId });
  errors.amount = '';
  clearFormData();
  emit('potTransactionCreated');
};

const emit = defineEmits(['potTransactionCreated']);
watch(
    () => formData.amount,
    (newValue) => {
      if (newValue < 0) {
        return;
      }

      if (!newValue) {
        potTransactionService.state.amount = 0;
        return;
      }

      potTransactionService.state.amount = newValue;
    }
);
</script>

<template>
  <form @submit.prevent="savePotTransaction">
    <Field id="limit" label="Amount" :error="errors.name ?? ''">
      <InputWithPrefix
          v-model="formData.amount"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <BaseButton type="submit" :text="submitButtonText" style="width: 100%;" />
  </form>
</template>

<style lang="scss" scoped>
</style>