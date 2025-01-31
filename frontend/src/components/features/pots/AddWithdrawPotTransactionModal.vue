<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {useTemplateRef} from "vue";
import AddPotTransactionForm from "@/components/features/pots/AddPotTransactionForm.vue";


const props = defineProps({
  pot: {
    type: Object,
    default: {},
  },
})

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
      :modalHeader="`Withdraw from ${pot.name}`"
      modalDescription="Reduce the balance in your savings pot by withdrawing funds. Enter the amount you’d like to withdraw and confirm your action below. Keep track of your progress towards your goals as you adjust your savings."
  >
    <AddPotTransactionForm
        :pot_id="pot.id"
        type="withdraw"
        submitButtonText="Confirm Withdrawal"
    />
  </Modal>
</template>

<style lang="scss" scoped>

</style>