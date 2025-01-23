<script setup>
import Menu from "@/components/menu/Menu.vue";
import Button from "@/components/buttons/Button.vue";
import AddPotModal from "@/components/modals/pots/AddPotModal.vue";
import {onMounted, useTemplateRef} from "vue";
import {usePots} from "@/composables/pots.js";
import PotList from "@/components/models/pots/PotList.vue";

const addPotModalRef = useTemplateRef('addPotModal');
const potService = usePots();

onMounted(async () => {
  await potService.fetchPotsData();
})
</script>

<template>
  <Menu/>
  <main>
    <div class="content-wrapper">
      <header class="model-header">
        <h1>Pots</h1>
        <Button @click="addPotModalRef.openModal()" class="button-primary" text="+ Add New Pot"/>
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