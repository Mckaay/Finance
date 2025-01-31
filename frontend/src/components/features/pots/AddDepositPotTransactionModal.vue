<script setup>
import Modal from "@/components/shared/modals/BaseModal.vue";
import {ref, useTemplateRef} from "vue";
import AddPotTransactionForm from "@/components/features/pots/AddPotTransactionForm.vue";
import ProgressBar from "@/components/shared/progress-bars/ProgressBar.vue";
import ProgressBarSmallWithAddition from "@/components/shared/progress-bars/ProgressBarSmallWithAddition.vue";

const props = defineProps({
  pot: {
    type: Object,
    default: {},
  },
})

const amount = ref(0);

const handleAmountUpdated = (value) => {
  amount.value = value;
}

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
      :modalHeader="`Add to ${pot.name}`"
      modalDescription="Add funds to your savings pot to help reach your financial goal faster. Review the details below and confirm the amount you’d like to add. Every contribution brings you closer to your target!"
  >
    <ProgressBarSmallWithAddition
      :target="pot.target"
      :balance="parseFloat(pot.balance)"
      type="deposit"
      :amount="parseFloat(amount)"
    />
    <AddPotTransactionForm
        type="deposit"
        :potId="pot.id"
        submitButtonText="Confirm Addition"
        @amount-updated="handleAmountUpdated"
    />
  </Modal>
</template>

<style lang="scss" scoped>

</style>