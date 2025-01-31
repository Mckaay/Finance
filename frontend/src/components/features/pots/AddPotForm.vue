<script setup>
import Input from "@/components/shared/forms/Input.vue";
import Field from "@/components/shared/forms/Field.vue";
import Select from "@/components/shared/forms/Select.vue";
import {usePots} from "@/composables/pots.js";
import {computed, onBeforeMount, onMounted, reactive, ref} from "vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

const addPotForm = reactive({
  name: '',
  target: '',
  theme_id: '',
});

const potService = usePots();

onMounted(async () => {
  await potService.fetchAvailableThemes()
})

const validationErrors = ref({});
const validationRules = {
  name: (value) => {
    if (!value || value.length < 3) {
      return "Name is required and should be at least 3 characters long";
    }
  },
  theme_id: (value) => {
    if (!value) {
      return "Category is required";
    }
  },
  target: (value) => {
    if (!value) {
      return "Amount is required";
    }
  },
};

const validateAddPotForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(addPotForm[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const savePot = async () => {
  validateAddPotForm();

  if (Object.keys(validationErrors.value).length > 0) {
    return;
  }

  await potService.savePot({ ...addPotForm });
  validationErrors.value = {};
  emit('potCreated');
};

const emit = defineEmits(['potCreated']);
</script>

<template>
  <form @submit.prevent="savePot">
    <Field id="name" label="Pot Name" :error="validationErrors['name'] ?? ''">
      <Input
          v-model="addPotForm.name"
          type="text"
          placeholder="e.g. Rainy Days"
          :required="true"
      />
    </Field>
    <Field id="theme" label="Theme" :error="validationErrors['theme_id'] ?? ''">
      <Select
          v-model="addPotForm.theme_id"
          type="text"
          placeholder="Pick Theme"
          :options="potService.availableThemes.value"
      />
    </Field>
    <Field id="target" label="Target" :error="validationErrors['target'] ?? ''">
      <InputWithPrefix
          v-model="addPotForm.target"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <BaseButton type="submit"  text="Add New Pot" style="width: 100%;"/>
  </form>
</template>

<style scoped>

</style>