<script setup>
import PotItem from "@/components/models/pots/PotItem.vue";
import EditPotModal from "@/components/modals/pots/EditPotModal.vue";
import {ref, useTemplateRef} from "vue";
import DeletePotModal from "@/components/modals/pots/DeletePotModal.vue";

const props = defineProps({
  pots: {
    type: Array,
    default: [],
  }
})

const editPotModalRef = useTemplateRef('editPotModal');
const deletePotModalRef = useTemplateRef('deletePotModal');

const potToBeEditedOrDeleted = ref({});

const openEditModal = (pot) => {
  if (pot.id !== 0) {
    potToBeEditedOrDeleted.value = pot;
  }

  editPotModalRef?.value.openModal();
}

const openDeleteModal = (pot) => {
  if (pot.id !== 0) {
    potToBeEditedOrDeleted.value = pot;
  }

  deletePotModalRef?.value.openModal();
}
</script>

<template>
  <section v-if="pots.length > 0" class="pot-list">
    <EditPotModal ref="editPotModal" :pot="potToBeEditedOrDeleted"/>
    <DeletePotModal ref="deletePotModal"
      :id="potToBeEditedOrDeleted.id"
                    :name="potToBeEditedOrDeleted.name"
    />
    <PotItem v-for="pot in props.pots" :key="pot.id" :pot="pot" @edit="openEditModal" @delete="openDeleteModal"/>
  </section>
</template>

<style scoped>
.pot-list {
  display: grid;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    grid-template-columns: 1fr 1fr;
  }
}
</style>