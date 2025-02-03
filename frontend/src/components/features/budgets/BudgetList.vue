<script setup>
import BudgetListItem from "@/components/features/budgets/BudgetListItem.vue";
import {inject, ref, useTemplateRef} from "vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import EditBudgetForm from "@/components/features/budgets/EditBudgetForm.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import {useBudgets} from "@/composables/budgets.js";

const budgetService = useBudgets()

const props = defineProps({
  budgets: {
    type: Array,
    default: [],
  }
})

const editBudgetModal = ref(null);
const deleteBudgetModal = ref(null);

const openDeleteModal = (budget) => {
  if (budget.id == null) {
    return;
  }

  budgetService.state.selectedForEditOrDelete = budget;
  deleteBudgetModal?.value.openModal();
}

const openEditModal = (budget) => {
  if (budget.id == null) {
    return;
  }

  budgetService.state.selectedForEditOrDelete = budget;
  editBudgetModal?.value.openModal();
}

const deleteBudget = async () => {
  if (budgetService.state.selectedForEditOrDelete.id === 0) {
    return;
  }
  await budgetService.deleteBudget(budgetService.state.selectedForEditOrDelete.id);
  deleteBudgetModal.value.close();
};
</script>

<template>
  <section v-if="budgets.length > 0" class="budget-list">
    <BaseModal
        ref="editBudgetModal"
        headerText="Edit Budget"
        descriptionText="As your budgets change, feel free to update your spending limits."
    >
      <EditBudgetForm @budgetUpdated="editBudgetModal.close()"/>
    </BaseModal>
    <BaseModal
        ref="deleteBudgetModal"
        :headerText="`Delete ${budgetService.state.selectedForEditOrDelete.category.label}`"
        descriptionText="Are you sure you want to delete this budget? This action cannot be reversed, and all the data inside it will be removed forever."
    >
      <BaseButton @click="deleteBudget" type="button" variant="destroy" text="Yes, Confirm Deletion"
                  style="width: 100%;"/>
    </BaseModal>
    <BudgetListItem
        v-for="budget in budgets"
        :key="budget.id"
        :budget="budget"
        @edit="openEditModal"
        @delete="openDeleteModal"
    />
  </section>
</template>


<style scoped>
.budget-list {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    grid-column: 2 / -1;
  }
}
</style>