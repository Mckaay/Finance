<script setup>
import BaseInput from "@/components/shared/forms/BaseInput.vue";
import BaseField from "@/components/shared/forms/BaseField.vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import { usePots } from "@/composables/pots.js";
import { computed, onBeforeMount, onMounted, reactive, ref } from "vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import { useLoadingStore } from "@/stores/loading.js";
import { checkIfObjectHasEmptyProperties } from "@/service/helpers.js";

const potService = usePots();
const loadingStore = useLoadingStore();

const formData = reactive({
  name: "",
  target: "",
  theme_id: "",
});

const clearFormData = () => {
  formData.name = "";
  formData.target = "";
  formData.theme_id = "";
};

const errors = reactive({
  name: "",
  target: "",
  theme_id: "",
});

const clearErrors = () => {
  errors.name = "";
  errors.target = "";
  errors.theme_id = "";
};

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

const validateFormData = () => {
  if (!formData.name || formData.name.length < 3) {
    errors.limit = "Name is required and needs to have at least 3 characters";
  }

  if (!formData.theme_id) {
    errors.category_id = "Theme is required";
  }

  if (!formData.target) {
    errors.theme_id = "Amount is required";
  }
};

const savePot = async () => {
  if (loadingStore.loading) {
    return;
  }

  validateFormData();
  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await potService.savePot({ ...formData });
  clearErrors();
  clearFormData();
  emit("potCreated");
};

const emit = defineEmits(["potCreated"]);
</script>

<template>
  <form @submit.prevent="savePot">
    <BaseField
      id="name"
      label="Pot Name"
      :error="validationErrors['name'] ?? ''"
    >
      <BaseInput
        v-model="formData.name"
        type="text"
        placeholder="e.g. Rainy Days"
        :required="true"
      />
    </BaseField>
    <BaseField
      id="theme"
      label="Theme"
      :error="validationErrors['theme_id'] ?? ''"
    >
      <BaseSelect
        v-model="formData.theme_id"
        placeholder="Pick Theme"
        :options="potService.state.availableThemes"
      />
    </BaseField>
    <BaseField
      id="target"
      label="Target"
      :error="validationErrors['target'] ?? ''"
    >
      <InputWithPrefix
        v-model="formData.target"
        type="number"
        min="1"
        step="1"
        placeholder="e.g. 2000"
        :required="true"
      />
    </BaseField>
    <BaseButton type="submit" text="Add New Pot" style="width: 100%" />
  </form>
</template>

<style scoped></style>
