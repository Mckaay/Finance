<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {inject, useTemplateRef} from "vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

const budgetService = inject("budgetService");

const modalRef = useTemplateRef('modal');
const openModal = () => {
  modalRef.value.openModal();
}

defineExpose({
  openModal,
})

const deleteBudget = async () => {
  if (budgetService.currentlyClickedBudgetToBeEditedOrDeleted.value.id === 0) {
    return;
  }
  await budgetService.deleteBudget(budgetService.currentlyClickedBudgetToBeEditedOrDeleted.value.id);
  modalRef.value.close();
};
</script>

<template>
  <Modal
      ref="modal"
      :modalHeader="`Delete ${budgetService.currentlyClickedBudgetToBeEditedOrDeleted.value?.category?.label}`"
      modalDescription="Are you sure you want to delete this budget? This action cannot be reversed, and all the data inside it will be removed forever."
  >
    <BaseButton @click="deleteBudget" type="button" variant="destroy" text="Yes, Confirm Deletion" style="width: 100%;"/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>