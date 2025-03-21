<script setup>
import BaseCircle from "@/components/shared/icons/BaseCircle.vue";
import ThreeDotsDropdown from "@/components/shared/dropdowns/EditDeleteDropdown.vue";
import ProgressBarSmall from "@/components/shared/progress-bars/ProgressBarSmall.vue";
import { getFillPercentage } from "@/service/helpers.js";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";

defineProps({
  pot: {
    type: Object,
    default: () => {},
  },
});

const emit = defineEmits(["edit", "delete", "deposit", "withdraw"]);
</script>

<template>
  <article>
    <header>
      <div class="left-side-wrapper">
        <BaseCircle :color="pot?.theme?.color" />
        <h2>{{ pot.name }}</h2>
      </div>
      <ThreeDotsDropdown
        @edit="emit('edit', pot)"
        @delete="emit('delete', pot)"
      />
    </header>
    <section class="content">
      <div class="middle-content-wrapper">
        <div class="middle-top-wrapper">
          <p>Total Saved</p>
          <h1>${{ pot.balance }}</h1>
        </div>
        <div class="middle-bottom-wrapper">
          <ProgressBarSmall
            height="8px"
            :color="pot?.theme?.color"
            :width="getFillPercentage(pot.target, pot.balance)"
          />
          <div class="wrapper">
            <p class="bold">
              {{ getFillPercentage(pot.target, pot.balance) }}
            </p>
            <p>Target of ${{ pot.target }}</p>
          </div>
        </div>
      </div>
    </section>
    <section class="button-wrapper">
      <BaseButton
        style="width: 100%"
        variant="secondary"
        text="+ Add Money"
        @click="emit('deposit', pot)"
      />
      <BaseButton
        style="width: 100%"
        variant="secondary"
        text="Withdraw"
        @click="emit('withdraw', pot)"
      />
    </section>
  </article>
</template>

<style scoped>
article {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
  background-color: var(--clr-white);
  padding: var(--spacing-150) var(--spacing-125);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    padding: var(--spacing-150) var(--spacing-150);
  }

  & header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;

    & .left-side-wrapper {
      display: flex;
      align-items: center;
      gap: var(--spacing-100);
    }

    & h2 {
      color: var(--clr-grey-900);
    }
  }

  & .middle-content-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-100);

    & .middle-top-wrapper {
      display: flex;
      align-items: center;
      justify-content: space-between;

      & h1 {
        color: var(--clr-grey-900);
      }

      & p {
        font-size: var(--fs-87);
        color: var(--clr-grey-500);
      }
    }

    & .middle-bottom-wrapper {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-75);

      & .wrapper {
        display: flex;
        justify-content: space-between;
        font-size: var(--fs-87);
        color: var(--clr-grey-500);

        & .bold {
          font-weight: var(--fw-700);
        }
      }
    }
  }

  & .button-wrapper {
    display: flex;
    gap: var(--spacing-100);
  }
}
</style>
