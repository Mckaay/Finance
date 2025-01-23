<script setup>
import Modal from "@/components/modals/Modal.vue";
import {useTemplateRef} from "vue";
import EditPotForm from "@/components/forms/model/pots/EditPotForm.vue";

const props = defineProps({
  pot: {
    type: Object,
    default: {},
  }
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
      modalHeader="Edit Pot"
      modalDescription="If your saving targets change, feel free to update your pots."
  >
    <EditPotForm
    :id="pot.id"
    :name="pot.name"
    :theme_id="pot?.theme?.id"
    :target="pot.target"
    />
  </Modal>
</template>

<style lang="scss" scoped>

</style>