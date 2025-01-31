<script setup>
import TextAndLinkHeader from "@/components/shared/text/TextAndLinkHeader.vue";
import {computed} from "vue";
import JarIcon from "@/components/shared/icons/JarIcon.vue";

const props = defineProps({
  pots: {
    type: Array,
    default: [],
  }
})

const savedSum = computed(() => {
  let sum = 0;
  return props.pots.reduce((accumulator, pot) => {
    return accumulator + parseFloat(pot.balance);
  }, sum)
})
</script>

<template>
  <div class="wrap">
    <TextAndLinkHeader text="Pots" linkText="See Details" routeName="pots"/>
    <div class="summary-wrapper">
      <div class="saved-card">
        <JarIcon/>
        <div class="text-wrapper">
          <p class="saved-text">Total Saved</p>
          <h2>${{ savedSum }}</h2>
        </div>
      </div>
      <div class="list">
        <div class="list-item" v-for="pot in props.pots" :style="{ '--background-color': pot?.theme.color }">
          <div class="wrapper">
            <p class="pot-name">{{ pot.name }}</p>
            <p class="pot-balance">${{ pot.balance }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.wrap {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-125);
  padding: var(--spacing-150) var(--spacing-125);
  background-color: var(--clr-white);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    padding: var(--spacing-200) var(--spacing-200);
  }
}

.summary-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-125);

  @media screen and (min-width: 768px) {
    flex-direction: row;
  }
}
.list {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: var(--spacing-100);
  @media screen and (min-width: 768px) {
    width: 100%;
  }

  & .list-item {
    display: flex;
    gap: var(--spacing-100)
  }

  & .list-item::before {
    content: "";
    width: 4px;
    border-radius: var(--spacing-50);
    background-color: var(--background-color);
    min-height: 100%;
  }

  & .wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-25);
  }
}

.saved-card {
  display: flex;
  align-items: center;
  gap: var(--spacing-100);
  background-color: var(--clr-beige-100);
  padding: var(--spacing-100);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    width: 65%;
  }
}

.text-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-75);
}

.pot-name {
  font-size: var(--fs-75);
  color: var(--clr-grey-500);
}

.pot-balance {
  font-size: var(--fs-87);
  color: var(--clr-grey-900);
  font-weight: var(--fw-700);
}

.saved-text {
  font-size: var(--fs-87);
  color: var(--clr-grey-500);
}

h2 {
  color: var(--clr-grey-900);
}
</style>