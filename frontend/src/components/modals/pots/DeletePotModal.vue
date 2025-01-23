<script setup>
import Modal from "@/components/modals/Modal.vue";
import {useTemplateRef} from "vue";
import Button from "@/components/buttons/Button.vue";
import {usePots} from "@/composables/pots.js";

const props = defineProps({
  id: {
    type: Number,
    default: 0,
  },
  name: {
    type: String,
    default: "",
  }
});

const openModal = () => {
  modalRef.value.openModal();
}

defineExpose({
  openModal,
})

const potService = usePots();
const modalRef = useTemplateRef('modal');

const deletePot = async () => {
  if (props.id === 0) {
    return;
  }

  await potService.deletePot(props.id);

  modalRef.value.close();
}
</script>

<template>
  <Modal
      ref="modal"
      :modalHeader="`Delete ${props.name}?`"
      modalDescription="Are you sure you want to delete this pot? This action cannot be reversed, and all the data inside it will be removed forever."
  >
    <Button @click="deletePot" type="submit" class="button-destroy" text="Yes, confirm deletion" style="width: 100%;"/>
  </Modal>
</template>

<style lang="scss" scoped>

</style>