<script setup>
import Modal from "@/components/modals/Modal.vue";
import { useTemplateRef } from "vue";
import AddBudgetForm from "@/components/forms/model/budgets/AddBudgetForm.vue";

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
    <AddBudgetForm/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>