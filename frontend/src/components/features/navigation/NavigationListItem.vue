<script setup>
defineProps({
  text: {
    type: String,
    default: () => "",
  },
  routeName: {
    type: String,
    default: () => "",
  },
});
</script>

<template>
  <router-link :to="{ name: routeName }">
    <li class="navigation-item">
      <slot />
      <p class="navigation-item-text">
        {{ text }}
      </p>
    </li>
  </router-link>
</template>

<style>
.navigation-item {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: var(--spacing-25);
  padding: var(--spacing-50) 0 var(--spacing-75) 0;
  flex: 1;
  border-radius: var(--spacing-50) var(--spacing-50) 0 0;
  font-weight: var(--fw-700);

  @media screen and (min-width: 1280px) {
    max-width: unset;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: var(--spacing-100);
    padding: var(--spacing-100) var(--spacing-200);
    border-radius: 0 var(--spacing-50) var(--spacing-50) 0;
    width: 100%;
  }

  & .navigation-item-text {
    display: none;

    @media screen and (min-width: 768px) {
      display: block;
    }
  }
}
</style>
