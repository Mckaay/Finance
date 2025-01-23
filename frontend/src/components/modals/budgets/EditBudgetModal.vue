<script setup>
import Modal from "@/components/modals/Modal.vue";
import {useTemplateRef} from "vue";
import EditBudgetForm from "@/components/forms/model/budgets/EditBudgetForm.vue";

const props = defineProps({
  budget: {
    type: Object,
    default: {},
  }
});

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
    <EditBudgetForm
      :id="props.budget.id"
      :limit="props.budget.limit"
      :theme_id="props.budget?.theme?.id"
      :category_id="props.budget?.theme?.id"
    />
  </Modal>
</template>

<style lang="scss" scoped>

</style>