<script setup>

</script>

<template>
  <section class="summary">
    <h2>Spending Summary</h2>
    <div class="summary-items-wrapper">
      <div class="summary-item">
        <div class="name">Bills</div>
        <div class="cost-wrapper">
          <div class="spent">$150.00</div>
          <div class="limit">of $750.00</div>
        </div>
      </div>
      <div class="line"></div>
      <div class="summary-item">
        <div class="name">Bills</div>
        <div class="cost-wrapper">
          <div class="spent">$150.00</div>
          <div class="limit">of $750.00</div>
        </div>
      </div>
      <div class="line"></div>
      <div class="summary-item">
        <div class="name">Bills</div>
        <div class="cost-wrapper">
          <div class="spent">$150.00</div>
          <div class="limit">of $750.00</div>
        </div>
      </div>
      <div class="line"></div>
      <div class="summary-item">
        <div class="name">Bills</div>
        <div class="cost-wrapper">
          <div class="spent">$150.00</div>
          <div class="limit">of $750.00</div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.summary {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  & h2 {
    color: var(--clr-grey-900);
  }

  & .summary-items-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-100);
  }

  & .summary-item {
    display: grid;
    align-items: center;
    grid-template-columns: repeat(5, 1fr);

    & .name {
      display: flex;
      align-items: center;
      height: 100%;
      gap: var(--spacing-100);
      font-size: var(--fs-87);
      color: var(--clr-grey-500);
      grid-column: 1 / span 2;
    }

    & .name::before {
      display: block;
      content: "";
      align-self: stretch;
      width: 4px;
      background-color: var(--clr-green);
      border-radius: var(--spacing-50);
    }

    & .cost-wrapper {
      display: flex;
      align-items: center;
      gap: var(--spacing-50);
      justify-self: end;
      grid-column: 3 / -1;
    }

    & .spent {
      font-size: var(--fs-100);
      color: var(--clr-grey-900);
      font-weight: var(--fw-700);
    }

    & .limit {
      font-size: var(--fs-75);
      color: var(--clr-grey-500);
    }
  }

  & .line {
    display: block;
    height: 1px;
    background-color: var(--clr-grey-100);
  }
}
</style>