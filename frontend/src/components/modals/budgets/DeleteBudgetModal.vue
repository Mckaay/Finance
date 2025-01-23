<script setup>
import Modal from "@/components/modals/Modal.vue";
import Button from "@/components/buttons/Button.vue";
import { useTemplateRef } from "vue";
import {useBudgets} from "@/composables/budgets.js";

const props = defineProps({
  id: {
    type: Number,
    default: 0,
  },
  name: {
    type: String,
    default: "",
  }
})

const modalRef = useTemplateRef('modal');
const openModal = () => {
  modalRef.value.openModal();
}

defineExpose({
  openModal,
})

const budgetService = useBudgets();
const deleteBudget = async () => {
  if (props.id === 0) {
    return;
  }
  await budgetService.deleteBudget(props.id);
  modalRef.value.close();
};
</script>

<template>
  <Modal
      ref="modal"
      :modalHeader="`Delete ${props.name}`"
      modalDescription="Are you sure you want to delete this budget? This action cannot be reversed, and all the data inside it will be removed forever."
  >
    <Button @click="deleteBudget" type="button" class="button-destroy" text="Yes, Confirm Deletion" style="width: 100%;"/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>