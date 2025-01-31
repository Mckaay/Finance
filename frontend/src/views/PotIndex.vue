<script setup>
import AddPotModal from "@/components/features/pots/AddPotModal.vue";
import {onMounted, useTemplateRef} from "vue";
import {usePots} from "@/composables/pots.js";
import PotList from "@/components/features/pots/PotList.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import Navigation from "@/components/features/navigation/Navigation.vue";

const addPotModalRef = useTemplateRef('addPotModal');
const potService = usePots();

onMounted(async () => {
  await potService.fetchPotsData();
})
</script>

<template>
  <Navigation/>
  <main>
    <div class="content-wrapper">
      <header class="model-header">
        <h1>Pots</h1>
        <BaseButton @click="addPotModalRef.openModal()" text="+ Add New Pot"/>
        <AddPotModal ref="addPotModal"/>
      </header>
      <PotList :pots="potService.potsList.value"/>
    </div>
  </main>
</template>

<style>
main {
  padding-bottom: var(--spacing-200);
}

.content-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
}
</style>