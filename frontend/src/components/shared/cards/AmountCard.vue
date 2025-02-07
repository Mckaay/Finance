<script setup>
const props = defineProps({
  text: {
    type: String,
    default: () => "",
  },
  amount: {
    type: String,
    default: "$0",
  },
  backgroundColor: {
    type: String,
    default: "#201F24",
  },
  textColor: {
    type: String,
    default: "#FFF",
  },
  headerTextColor: {
    type: String,
    default: "#FFF",
  },
});
</script>

<template>
  <article class="card">
    <header>
      {{ text }}
    </header>
    <div class="amount">${{ amount }}</div>
  </article>
</template>

<style>
.card {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-75);
  justify-content: center;
  background-color: v-bind("props.backgroundColor");
  color: v-bind("props.textColor");
  padding: var(--spacing-125);
  border-radius: var(--spacing-75);
  width: 100%;

  @media screen and (min-width: 768px) {
    padding: var(--spacing-150);
  }

  & header {
    color: v-bind("props.headerTextColor");
    font-size: var(--fs-87);
  }

  & .amount {
    font-size: var(--fs-150);
    font-weight: var(--fw-700);
  }
}
</style>
