<script setup>
import PotListItem from "@/components/features/pots/PotListItem.vue";
import EditPotModal from "@/components/features/pots/EditPotModal.vue";
import {ref, useTemplateRef} from "vue";
import DeletePotModal from "@/components/features/pots/DeletePotModal.vue";
import AddDepositPotTransactionModal from "@/components/features/pots/AddDepositPotTransactionModal.vue";
import AddWithdrawPotTransactionModal from "@/components/features/pots/AddWithdrawPotTransactionModal.vue";

const props = defineProps({
  pots: {
    type: Array,
    default: [],
  }
})

const clickedPot = ref({});

const editPotModalRef = useTemplateRef('editPotModal');
const deletePotModalRef = useTemplateRef('deletePotModal');
const depositModalRef = useTemplateRef('depositModal');
const withdrawModalRef = useTemplateRef('withdrawModal');

const openEditModal = (pot) => {
  if (pot.id !== 0) {
    clickedPot.value = pot;
  }

  editPotModalRef?.value.openModal();
}

const openDeleteModal = (pot) => {
  if (pot.id !== 0) {
    clickedPot.value = pot;
  }

  deletePotModalRef?.value.openModal();
}

const openDepositModal = (pot) => {
  if (pot.id !== 0) {
    clickedPot.value = pot;
  }

  depositModalRef?.value.openModal();
}

const openWithdrawModal = (pot) => {
  if (pot.id !== 0) {
    clickedPot.value = pot;
  }

  withdrawModalRef?.value.openModal();
}
</script>

<template>
  <section class="pot-list" v-if="pots.length > 0">
    <EditPotModal
        ref="editPotModal"
        :pot="clickedPot"
    />
    <DeletePotModal
        ref="deletePotModal"
        :pot="clickedPot"
    />
    <AddDepositPotTransactionModal
        ref="depositModal"
        :pot="clickedPot"
    />
    <AddWithdrawPotTransactionModal
        ref="withdrawModal"
        :pot="clickedPot"
    />
    <PotListItem
        v-for="pot in props.pots"
        :key="pot.id" :pot="pot"
        @edit="openEditModal"
        @delete="openDeleteModal"
        @deposit="openDepositModal"
        @withdraw="openWithdrawModal"
    />
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