<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {useTemplateRef} from "vue";
import AddTransactionForm from "@/components/features/transactions/AddTransactionForm.vue";

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
      modalHeader="Add New Transaction"
      modalDescription="Create transactions to manage, control your spendings and incomes."
  >
    <AddTransactionForm/>
  </Modal>
</template>

<style scoped>

</style>