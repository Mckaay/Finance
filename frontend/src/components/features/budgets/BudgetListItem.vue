<script setup>
import ThreeDotsDropdown from "@/components/shared/dropdowns/EditDeleteDropdown.vue";
import ProgressBar from "@/components/shared/progress-bars/ProgressBar.vue";
import {getFillPercentage, getRemainingAmount} from "@/service/helpers.js";
import ThemeCircle from "@/components/shared/icons/ThemeCircle.vue";
import TransactionSummaryList from "@/components/features/transactions/TransactionSummaryList.vue";
import TextAndLinkHeader from "@/components/shared/text/TextAndLinkHeader.vue";

const props = defineProps({
  budget: {
    type: Object,
    default: {
      category: {
        name: "",
      },
      theme: {
        color: "",
      },
      transactions: [],
    },
  }
});

const emit = defineEmits(['edit', 'delete']);
</script>

<template>
  <article>
    <div class="budget-header">
      <div class="left-side-wrapper">
        <ThemeCircle :color="budget.theme.color"/>
        <div class="budget-category">{{ budget.category.label }}</div>
      </div>
      <ThreeDotsDropdown @edit="emit('edit',budget)" @delete="emit('delete', budget)"/>
    </div>
    <div class="spending-summary">
      <p class="maximum-spending">Maximum of ${{ budget.limit }}</p>
      <ProgressBar
          :width="getFillPercentage(budget.limit, budget.monthlySpendings)"
          :color="budget.theme.color"
      />
      <div class="summary-section-details-wrapper">
        <div class="spent-wrapper">
          <div class="costs-wrapper">
            <p>Spent</p>
            <p>${{ Math.abs(budget.monthlySpendings) }}</p>
          </div>
        </div>
        <div class="remaining-wrapper">
          <div class="costs-wrapper">
            <p>Remaining</p>
            <p>{{ getRemainingAmount(budget.limit, budget.monthlySpendings) }}</p>
          </div>
        </div>
      </div>
    </div>
    <section class="latest-spending-section">
      <TransactionSummaryList :transactions="props.budget.transactions">
        <TextAndLinkHeader
            text="Latest Spendings"
            routeName="transactions"
            linkText="See All"
        />
      </TransactionSummaryList>
    </section>
  </article>
</template>

<style scoped>
article {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-125);
  font-size: var(--fs-87);
  font-weight: var(--fw-700);
  color: var(--clr-grey-900);
  padding: var(--spacing-150) var(--spacing-125);
  background-color: var(--clr-white);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    padding: var(--spacing-200) var(--spacing-200);
  }

  & .budget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  & .left-side-wrapper {
    display: flex;
    align-items: center;
    gap: var(--spacing-100);
  }

  & .budget-category {
    font-size: var(--fs-125);
  }

  & .spending-summary {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-100);
  }

  & .summary-section-details-wrapper {
    display: flex;
    gap: var(--spacing-100);
  }

  & .maximum-spending {
    font-weight: var(--fw-400);
    color: var(--clr-grey-500);
    line-height: 150%;
  }

  & .spent-wrapper, .remaining-wrapper {
    display: flex;
    align-items: stretch;
    gap: var(--spacing-100);
    width: 50%;
  }

  & .spent-wrapper > p:first-of-type {
    color: var(--clr-grey-500);
    font-size: var(--fs-75);
    font-weight: var(--fw-400);
    line-height: 150%;
  }

  & .remaining-wrapper > p:first-of-type {
    color: var(--clr-grey-500);
    font-size: var(--fs-75);
    font-weight: var(--fw-400);
    line-height: 150%;
  }

  & .remaining-wrapper::before {
    content: "";
    display: flex;
    align-items: center;
    width: 4px;
    background-color: var(--clr-beige-100);
    border-radius: var(--spacing-50);
  }

  & .spent-wrapper::before {
    content: "";
    display: flex;
    align-items: center;
    width: 4px;
    background-color: v-bind('budget.theme.color');
    border-radius: var(--spacing-50);
  }

  & .costs-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-25);
  }

  & .costs-wrapper > p:first-of-type {
    color: var(--clr-grey-500);
    font-weight: var(--fw-400);
    font-size: var(--fs-75);
  }

  & .latest-spending-section {
    display: flex;
    flex-direction: column;
    background-color: var(--clr-beige-100);
    padding: var(--spacing-100);
    border-radius: var(--spacing-75);
    gap: var(--spacing-125);

    @media screen and (min-width: 768px) {
      padding: var(--spacing-125);
    }
  }

  & .latest-spending-section-header > p {
    font-size: var(--fs-100);
    font-weight: var(--fw-700);
  }

  & .latest-spending-section-header {
    display: flex;
    justify-content: space-between;
  }

  .see-all {
    all: unset;
  }

  & .transactions-list {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: var(--spacing-75);
    overflow-x: auto;
  }
}
</style>