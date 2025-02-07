<script setup>
import { ref } from "vue";
import BaseClose from "@/components/shared/icons/BaseClose.vue";

defineProps({
  headerText: {
    type: String,
    default: () => "",
  },
  descriptionText: {
    type: String,
    default: () => "",
  },
});

const dialog = ref(null);

const openModal = () => {
  dialog.value.showModal();
};

function close() {
  dialog.value?.close();
}

defineExpose({
  openModal,
  close,
});
</script>

<template>
  <dialog ref="dialog">
    <div class="modal-content-wrapper">
      <header>
        <h1>{{ headerText }}</h1>
        <BaseClose class="close-button" @click="close" />
      </header>
      <p v-if="descriptionText" class="modal-description">
        {{ descriptionText }}
      </p>
      <slot />
    </div>
  </dialog>
</template>

<style>
dialog {
  margin: auto;
  border: 0;
  border-radius: var(--spacing-75);
  padding: var(--spacing-200) var(--spacing-200);
  width: 80%;
  max-width: 560px;

  & .modal-content-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-125);
  }

  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  & .close-button:hover {
    cursor: pointer;
  }

  & h1 {
    color: var(--clr-grey-900);
    font-size: var(--fs-110);

    @media screen and (min-width: 560px) {
      font-size: var(--fs-h1);
    }
  }

  & .modal-description {
    font-size: var(--fs-87);
    line-height: 1.5;
    color: var(--clr-grey-500);
  }

  & form {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-125);
  }

  & .v-select {
    width: 100%;

    & .vs__search {
      width: 100%;
    }
  }
}

dialog::backdrop {
  background-color: rgba(0, 0, 0, 0.8);
}
</style>
