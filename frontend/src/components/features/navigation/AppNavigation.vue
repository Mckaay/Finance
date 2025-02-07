<script setup>
import NavigationResizeButton from "@/components/features/navigation/NavigationResizeButton.vue";
import BigLogoIcon from "@/components/shared/icons/BigLogoIcon.vue";
import SmallLogoIcon from "@/components/shared/icons/SmallLogoIcon.vue";
import { useNavigationStore } from "@/stores/navigation.js";
import NavigationList from "@/components/features/navigation/NavigationList.vue";

const navigationStore = useNavigationStore();
</script>

<template>
  <nav
    class="navigation"
    :class="{ narrowed: navigationStore.narrow }"
  >
    <header class="logo">
      <BigLogoIcon v-if="!navigationStore.narrow" />
      <SmallLogoIcon
        v-else
        class="small-logo"
      />
    </header>
    <NavigationList />
    <NavigationResizeButton
      text="Minimize Menu"
      @click="navigationStore.narrow = !navigationStore.narrow"
    />
  </nav>
</template>

<style>
.navigation {
  --narrow-navigation-width: 88px;
  --extended-navigation-width: 300px;

  position: fixed;
  bottom: 0;
  font-size: var(--fs-80);
  color: var(--clr-grey-300);
  background-color: var(--clr-grey-900);
  padding: var(--spacing-50) var(--spacing-100) 0 var(--spacing-100);
  width: 100%;
  transition-property: width;
  transition-duration: 50ms;
  z-index: 2;

  @media screen and (min-width: 768px) {
    padding: var(--spacing-50) var(--spacing-250) 0 var(--spacing-250);
  }

  @media screen and (min-width: 1280px) {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-150);
    position: static;
    padding: 0;
    width: var(--extended-navigation-width);
    font-size: var(--fs-100);
  }

  & .logo {
    display: none;
    padding: var(--spacing-250) var(--spacing-200);

    @media screen and (min-width: 1280px) {
      display: block;
    }
  }

  & ul {
    display: flex;
    align-items: center;
    justify-content: space-between;
    list-style: none;
    padding: 0;

    @media screen and (min-width: 768px) {
      max-width: 800px;
      margin: auto;
    }

    @media screen and (min-width: 1280px) {
      max-width: unset;
      flex-direction: column;
      align-items: flex-start;
      gap: var(--spacing-25);
      padding-right: var(--spacing-150);
      margin: unset;
    }
  }

  .navigation-item:hover {
    cursor: pointer;
    color: var(--clr-white);

    & svg > * {
      fill: var(--clr-white);
    }
  }

  a {
    all: unset;
    width: 100%;
    max-width: 104px;

    @media screen and (min-width: 1280px) {
      max-width: unset;
    }
  }
}

.navigation:has(.router-link-active) {
  & .router-link-active {
    background-color: var(--clr-white);
    color: var(--clr-grey-900);
    box-shadow: 0 -4px 0 var(--clr-green) inset;
    border-radius: var(--spacing-50) var(--spacing-50) 0 0;

    @media screen and (min-width: 1280px) {
      border-radius: 0 var(--spacing-50) var(--spacing-50) 0;
      box-shadow: 4px 0 0 var(--clr-green) inset;
    }

    .navigation-item:hover {
      cursor: unset;
      color: var(--clr-grey-900);
    }

    & svg > * {
      fill: var(--clr-green);
    }
  }
}

.navigation.narrowed {
  @media screen and (min-width: 1280px) {
    width: var(--narrow-navigation-width);

    .navigation-item-text,
    .toggle-button {
      display: none;
    }

    & ul {
      padding: 0;

      & li {
        padding: var(--spacing-100) var(--spacing-200) var(--spacing-100)
          var(--spacing-200);
        justify-content: center;
      }
    }

    .arrow-fat {
      transform: rotateY(-180deg);
    }
  }
}
</style>
