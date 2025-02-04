<script setup>
import {onMounted, ref, useTemplateRef} from "vue";
import {usePots} from "@/composables/pots.js";
import PotList from "@/components/features/pots/PotList.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import Navigation from "@/components/features/navigation/Navigation.vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import AddPotForm from "@/components/features/pots/AddPotForm.vue";
import DeletePotForm from "@/components/features/pots/DeletePotForm.vue";
import EditPotForm from "@/components/features/pots/EditPotForm.vue";
import AddPotTransactionForm from "@/components/features/pots/AddPotTransactionForm.vue";
import ProgressBarSmallWithAddition from "@/components/shared/progress-bars/ProgressBarSmallWithAddition.vue";
import {usePotTransactions} from "@/composables/potTransactions.js";

const potService = usePots();
const potTransactionService = usePotTransactions();

const addPotModal = ref(null);
const editPotModal = ref(null);
const deletePotModal = ref(null);
const depositToPotModal = ref(null);
const withdrawFromPotModal = ref(null);

onMounted(async () => {
  if (potService.state.list.length > 0) {
    return;
  }

  await potService.fetchPotsData();
  await potService.fetchAvailableThemes()
})
</script>

<template>
  <Navigation/>
  <main>
    <div class="content-wrapper">
      <header class="model-header">
        <h1>Pots</h1>
        <BaseButton @click="addPotModal.openModal()" text="+ Add New Pot"/>
        <BaseModal
            ref="addPotModal"
            headerText="Add New Pot"
            descriptionText="Create a pot to set savings targets. These can help keep you on track as you save for special purchases."
        >
          <AddPotForm @potCreated="addPotModal.close()"/>
        </BaseModal>
        <BaseModal
            ref="editPotModal"
            headerText="Edit Pot"
            descriptionText="If your saving targets change, feel free to update your pots."
        >
          <EditPotForm
              @potEdited="editPotModal.close()"
              :pot="potService.state.selectedForEditOrDelete"
              :availableThemes="potService.state.availableThemes"
          />
        </BaseModal>
        <BaseModal
            ref="deletePotModal"
            :headerText="`Delete ${potService.state.selectedForEditOrDelete.name ?? ''}`"
            descriptionText="Are you sure you want to delete this pot? This action cannot be reversed, and all the data inside it will be removed forever."
        >
          <DeletePotForm @potDeleted="deletePotModal.close()"/>
        </BaseModal>
        <BaseModal
            ref="depositToPotModal"
            :headerText="`Add to ${potService.state.selectedForEditOrDelete.name ?? ''}`"
            descriptionText="Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus  hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet."
        >
          <ProgressBarSmallWithAddition
              :target="parseFloat(potService.state.selectedForEditOrDelete.target)"
              :balance="parseFloat(potService.state.selectedForEditOrDelete.balance)"
              :amount="parseFloat(potTransactionService.state.amount)"
          />
          <AddPotTransactionForm
              :potId="potService.state.selectedForEditOrDelete.id"
              submitButtonText="Confirm Addition"
              @potTransactionCreated="depositToPotModal.close()"
          />
        </BaseModal>
        <BaseModal
            ref="withdrawFromPotModal"
            :headerText="`Withdraw from ${potService.state.selectedForEditOrDelete.name ?? ''}`"
            descriptionText="Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus  hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet."
        >
          <ProgressBarSmallWithAddition
              type="withdraw"
              :target="parseFloat(potService.state.selectedForEditOrDelete.target)"
              :balance="parseFloat(potService.state.selectedForEditOrDelete.balance)"
              :amount="parseFloat(potTransactionService.state.amount)"
          />
          <AddPotTransactionForm
              type="withdraw"
              :potId="potService.state.selectedForEditOrDelete.id"
              submitButtonText="Confirm Withdrawal"
              @potTransactionCreated="withdrawFromPotModal.close()"
          />
        </BaseModal>
      </header>
      <PotList
          :pots="potService.state.list"
          @openEditModal="editPotModal.openModal()"
          @openDeleteModal="deletePotModal.openModal()"
          @openDepositModal="depositToPotModal.openModal()"
          @openWithdrawModal="withdrawFromPotModal.openModal()"
      />
    </div>
  </main>
</template>

<style>
main {
  padding-bottom: var(--spacing-200);
}

.content-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
}
</style>