<script setup>
import { onMounted, ref, useTemplateRef } from "vue";
import { usePots } from "@/composables/pots.js";
import PotList from "@/components/features/pots/PotList.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import AppNavigation from "@/components/features/navigation/AppNavigation.vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import AddPotForm from "@/components/features/pots/AddPotForm.vue";
import DeletePotForm from "@/components/features/pots/DeletePotForm.vue";
import EditPotForm from "@/components/features/pots/EditPotForm.vue";
import AddPotTransactionForm from "@/components/features/pots/AddPotTransactionForm.vue";
import ProgressBarSmallWithAddition from "@/components/shared/progress-bars/ProgressBarSmallWithAddition.vue";
import { usePotTransactions } from "@/composables/potTransactions.js";

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
  await potService.fetchAvailableThemes();
});
</script>

<template>
  <AppNavigation />
  <main>
    <div class="content-wrapper">
      <header class="model-header">
        <h1>Pots</h1>
        <BaseButton text="+ Add New Pot" @click="addPotModal.openModal()" />
        <BaseModal
          ref="addPotModal"
          header-text="Add New Pot"
          description-text="Create a pot to set savings targets. These can help keep you on track as you save for special purchases."
        >
          <AddPotForm @pot-created="addPotModal.close()" />
        </BaseModal>
        <BaseModal
          ref="editPotModal"
          header-text="Edit Pot"
          description-text="If your saving targets change, feel free to update your pots."
        >
          <EditPotForm
            :pot="potService.state.selectedForEditOrDelete"
            :available-themes="potService.state.availableThemes"
            @pot-edited="editPotModal.close()"
          />
        </BaseModal>
        <BaseModal
          ref="deletePotModal"
          :header-text="`Delete ${potService.state.selectedForEditOrDelete.name ?? ''}`"
          description-text="Are you sure you want to delete this pot? This action cannot be reversed, and all the data inside it will be removed forever."
        >
          <DeletePotForm @pot-deleted="deletePotModal.close()" />
        </BaseModal>
        <BaseModal
          ref="depositToPotModal"
          :header-text="`Add to ${potService.state.selectedForEditOrDelete.name ?? ''}`"
          description-text="Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus  hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet."
        >
          <ProgressBarSmallWithAddition
            :target="
              parseFloat(potService.state.selectedForEditOrDelete.target)
            "
            :balance="
              parseFloat(potService.state.selectedForEditOrDelete.balance)
            "
            :amount="parseFloat(potTransactionService.state.amount)"
          />
          <AddPotTransactionForm
            :pot-id="potService.state.selectedForEditOrDelete.id"
            submit-button-text="Confirm Addition"
            @pot-transaction-created="depositToPotModal.close()"
          />
        </BaseModal>
        <BaseModal
          ref="withdrawFromPotModal"
          :header-text="`Withdraw from ${potService.state.selectedForEditOrDelete.name ?? ''}`"
          description-text="Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus  hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet."
        >
          <ProgressBarSmallWithAddition
            type="withdraw"
            :target="
              parseFloat(potService.state.selectedForEditOrDelete.target)
            "
            :balance="
              parseFloat(potService.state.selectedForEditOrDelete.balance)
            "
            :amount="parseFloat(potTransactionService.state.amount)"
          />
          <AddPotTransactionForm
            type="withdraw"
            :pot-id="potService.state.selectedForEditOrDelete.id"
            submit-button-text="Confirm Withdrawal"
            @pot-transaction-created="withdrawFromPotModal.close()"
          />
        </BaseModal>
      </header>
      <PotList
        :pots="potService.state.list"
        @open-edit-modal="editPotModal.openModal()"
        @open-delete-modal="deletePotModal.openModal()"
        @open-deposit-modal="depositToPotModal.openModal()"
        @open-withdraw-modal="withdrawFromPotModal.openModal()"
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
