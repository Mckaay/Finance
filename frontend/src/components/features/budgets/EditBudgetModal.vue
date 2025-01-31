<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {useTemplateRef} from "vue";
import EditBudgetForm from "@/components/features/budgets/EditBudgetForm.vue";


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
      modalHeader="Edit Budget"
      modalDescription="As your budgets change, feel free to update your spending limits."
  >
    <EditBudgetForm/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>