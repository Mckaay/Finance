<script setup>
import PotListItem from "@/components/features/pots/PotListItem.vue";
import { usePots } from "@/composables/pots.js";

const props = defineProps({
  pots: {
    type: Array,
    default: () => [],
  },
});

const potService = usePots();

const emit = defineEmits([
  "openEditModal",
  "openDeleteModal",
  "openDepositModal",
  "openWithdrawModal",
]);

const emitOpenModalEvent = (pot) => {
  if (pot.id === 0) {
    return;
  }

  potService.state.selectedForEditOrDelete = pot;
  emit("openEditModal");
};

const emitOpenDeleteModal = (pot) => {
  if (pot.id === 0) {
    return;
  }

  potService.state.selectedForEditOrDelete = pot;
  emit("openDeleteModal");
};

const emitOpenDepositModal = (pot) => {
  if (pot.id === 0) {
    return;
  }

  potService.state.selectedForEditOrDelete = pot;
  emit("openDepositModal");
};

const emitOpenWithdrawModal = (pot) => {
  if (pot.id === 0) {
    return;
  }

  potService.state.selectedForEditOrDelete = pot;
  emit("openWithdrawModal");
};
</script>
<template>
  <section
    v-if="pots.length > 0"
    class="pot-list"
  >
    <PotListItem
      v-for="pot in props.pots"
      :key="pot.id"
      :pot="pot"
      @edit="emitOpenModalEvent"
      @delete="emitOpenDeleteModal"
      @deposit="emitOpenDepositModal"
      @withdraw="emitOpenWithdrawModal"
    />
  </section>
</template>

<style scoped>
.pot-list {
  display: grid;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
