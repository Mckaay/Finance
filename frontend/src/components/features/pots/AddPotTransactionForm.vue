<script setup>
import Field from "@/components/shared/forms/Field.vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import {reactive, ref, watch} from "vue";
import {usePotTransactions} from "@/composables/potTransactions.js";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

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

const addPotTransactionForm = reactive({
  amount: 0,
  type: props.type ?? '',
});

const validationErrors = ref({});
const validationRules = {
  type: (value) => {
    if (!value) {
      return "Type is required";
    }
  },
  amount: (value) => {
    if (!value || value < 0) {
      return "Amount is required";
    }
  },
};

const validatePotTransactionForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(addPotTransactionForm[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const potTransactionService = usePotTransactions();
const savePotTransaction = async () => {
  validatePotTransactionForm();

  if (Object.keys(validationErrors.value).length > 0) {
    console.log('Im here');
    console.log(Object.keys(validationErrors.value));
    return;
  }

  await potTransactionService.savePotTransactions({ ...addPotTransactionForm, pot_id: props.potId });
  validationErrors.value = {};
};

const emit = defineEmits(['amount-updated']);
watch(
    () => addPotTransactionForm.amount,
    (newValue) => {
      if (newValue < 0) {
        return;
      }

      if (!newValue) {
        emit('amount-updated', 0);
        return;
      }

      emit('amount-updated', newValue);
    }
);
</script>

<template>
  <form @submit.prevent="savePotTransaction">
    <Field id="limit" label="Amount" :error="validationErrors['amount'] ?? ''">
      <InputWithPrefix
          v-model="addPotTransactionForm.amount"
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