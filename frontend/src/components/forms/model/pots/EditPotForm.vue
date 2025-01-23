<script setup>
import Input from "@/components/forms/base/Input.vue";
import Field from "@/components/forms/base/Field.vue";
import Button from "@/components/buttons/Button.vue";
import Select from "@/components/forms/base/Select.vue";
import {usePots} from "@/composables/pots.js";
import {computed, onMounted, reactive, ref} from "vue";
import InputWithPrefix from "@/components/forms/base/InputWithPrefix.vue";

const props = defineProps({
  id: {
    type: Number,
    default: 0,
  },
  name: {
    type: String,
    default: "",
  },
  theme_id: {
    type: Number,
    default: 0,
  },
  target: {
    type: String,
    default: "0",
  },
});

const editPotForm = computed( () => {
  return reactive({
    name: props.name ?? '',
    target: props.target ?? 0,
    theme_id: props.theme_id ?? 0,
  });
});

const potService = usePots();

onMounted(async () => {
  await potService.fetchAvailableThemes()
})

const availableThemes = computed(() => {
  const themes = potService?.availableThemes?.value || [];
  return themes.map((theme) => {
    return {
      value: theme.id,
      label: theme.name,
      disabled: theme.disabled,
    }
  })
});

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

const validateEditPotForm = () => {
  validationErrors.value = {};

  for (const [field, rule] of Object.entries(validationRules)) {
    const error = rule(editPotForm.value[field]);
    if (error) {
      validationErrors.value[field] = error;
    }
  }
};

const updatePot = async () => {
  validateEditPotForm();

  if (Object.keys(validationErrors.value).length > 0) {
    return;
  }

  await potService.updatePot(props.id,{ ...editPotForm.value });
  validationErrors.value = {};
};
</script>

<template>
  <form @submit.prevent="updatePot">
    <Field id="name" label="Pot Name" :error="validationErrors['name'] ?? ''">
      <Input
          v-model="editPotForm.name"
          type="text"
          placeholder="e.g. Rainy Days"
          :required="true"
      />
    </Field>
    <Field id="theme" label="Theme" :error="validationErrors['theme_id'] ?? ''">
      <Select
          v-model="editPotForm.theme_id"
          type="text"
          placeholder="Pick Theme"
          :options="availableThemes"
      />
    </Field>
    <Field id="target" label="Target" :error="validationErrors['target'] ?? ''">
      <InputWithPrefix
          v-model="editPotForm.target"
          type="number"
          min="1"
          step="1"
          placeholder="e.g. 2000"
          :required="true"
      />
    </Field>
    <Button type="submit" class="button-primary" text="Save Changes" style="width: 100%;"/>
  </form>
</template>

<style scoped>

</style>