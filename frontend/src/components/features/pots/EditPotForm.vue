<script setup>
import BaseInput from "@/components/shared/forms/BaseInput.vue";
import BaseField from "@/components/shared/forms/BaseField.vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import { usePots } from "@/composables/pots.js";
import { computed, onMounted, reactive, ref } from "vue";
import InputWithPrefix from "@/components/shared/forms/InputWithPrefix.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import { checkIfObjectHasEmptyProperties } from "@/service/helpers.js";

const props = defineProps({
  pot: {
    type: Object,
    default: () => ({
      id: {
        type: Number,
        default: () => 0,
      },
      name: {
        type: String,
        default: () => "",
      },
      theme: {
        type: Object,
        default: {},
      },
      target: {
        type: String,
        default: "0",
      },
    }),
  },
  availableThemes: {
    type: Array,
    default: () => [],
  },
});

const potService = usePots();

const formData = computed(() => {
  return reactive({
    name: props.pot.name ?? "",
    target: props.pot.target ?? 0,
    theme_id: props.pot.theme?.value ?? 0,
  });
});

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

const validateFormData = () => {
  if (!formData.value.name || formData.value.name.length < 3) {
    errors.name = "Name is required and should be at least 3 characters long";
  }

  if (!formData.value.target) {
    errors.category_id = "Target is required";
  }

  if (!formData.value.theme_id) {
    errors.theme_id = "Theme is required";
  }
};

const emit = defineEmits(["potEdited"]);
const updatePot = async () => {
  validateFormData();

  if (!checkIfObjectHasEmptyProperties(errors)) {
    return;
  }

  await potService.updatePot(props.id, { ...formData.value });
  clearErrors();
  emit("potEdited");
};
</script>

<template>
  <form @submit.prevent="updatePot">
    <BaseField id="name" label="Pot Name" :error="errors.name ?? ''">
      <BaseInput
        v-model="formData.name"
        type="text"
        placeholder="e.g. Rainy Days"
        :required="true"
      />
    </BaseField>
    <BaseField id="theme" label="Theme" :error="errors.theme_id ?? ''">
      <BaseSelect
        v-model="formData.theme_id"
        type="text"
        placeholder="Pick Theme"
        :options="availableThemes"
      />
    </BaseField>
    <BaseField id="target" label="Target" :error="errors.target ?? ''">
      <InputWithPrefix
        v-model="formData.target"
        type="number"
        min="1"
        step="1"
        placeholder="e.g. 2000"
        :required="true"
      />
    </BaseField>
    <BaseButton type="submit" text="Save Changes" style="width: 100%" />
  </form>
</template>

<style scoped></style>
