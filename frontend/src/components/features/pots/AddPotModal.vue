<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {useTemplateRef} from "vue";
import AddPotForm from "@/components/features/pots/AddPotForm.vue";

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
      modalHeader="Add New Pot"
      modalDescription="Create a pot to set savings targets. These can help keep you on track as you save for special purchases."
  >
    <AddPotForm/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>