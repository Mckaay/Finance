<script setup>
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import {usePots} from "@/composables/pots.js";
import {useLoadingStore} from "@/stores/loading.js";

const potService = usePots();
const loadingStore = useLoadingStore()

const props = defineProps({
  id: {
    type: Number,
    default: 0,
  }
})

const emit = defineEmits('potDeleted')
const deletePot = async () => {
  if (props.id === 0) {
    return;
  }

  if (loadingStore.loading) {
    return;
  }

  await potService.deletePot(props.id);
  emit('potDeleted');
}
</script>

<template>
  <BaseButton @click="deletePot" type="submit" variant="destroy" text="Yes, confirm deletion" style="width: 100%;"/>
</template>

<style scoped>

</style>