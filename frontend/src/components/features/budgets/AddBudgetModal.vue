<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import { useTemplateRef } from "vue";
import AddBudgetForm from "@/components/features/budgets/AddBudgetForm.vue";

const modalRef = useTemplateRef('modal');
const openModal = () => {
  modalRef.value.openModal();
}

defineExpose({
  openModal,
})
</script>

<template>
  <Modal
      ref="modal"
      modalHeader="Add New Budget"
      modalDescription="Choose a category to set a spending budget. These categories can help you monitor spendings."
  >
    <AddBudgetForm @budget-created="modalRef.close()" />
  </Modal>
</template>

<style lang="scss" scoped>

</style>