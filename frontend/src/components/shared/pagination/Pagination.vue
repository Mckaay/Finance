<script setup>
import { computed, ref } from 'vue'
import PaginationPageNumberButton from "@/components/shared/pagination/PaginationPageNumberButton.vue";
import PaginationArrowButton from "@/components/shared/pagination/PaginationArrowButton.vue";

const props = defineProps({
  currentPage: {
    type: Number,
    default: 1
  },
  lastPage: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['update:currentPage'])

function handlePageClick(page) {
  if (typeof page === 'number' && page >= 1 && page <= props.lastPage) {
    emit('update:currentPage', page)
  }
}

function createPaginationRange(currentPage, lastPage) {
  if (lastPage <= 5) {
    return Array.from({ length: lastPage }, (_, i) => i + 1);
  }

  if (currentPage <= 3) {
    return [1, 2, 3, '...', lastPage];
  }

  if (currentPage >= lastPage - 2) {
    return [1, '...', lastPage - 2, lastPage - 1, lastPage];
  }

  return [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', lastPage];
}

const paginationItems = computed(() => {
  return createPaginationRange(props.currentPage, props.lastPage)
})
</script>

<template>
  <div class="pagination-wrapper">
    <PaginationArrowButton
        :disabled="props.currentPage === 1"
        variant="previous"
        text="Prev"
        @click="handlePageClick(props.currentPage - 1)"
    />
    <div class="numeric-buttons-wrapper">
      <PaginationPageNumberButton
          v-for="(item, index) in paginationItems"
          :key="index"
          :page="item"
          :disabled="item === '...'"
          :class="{ active: item === props.currentPage }"
          @click="handlePageClick(item)"
      />
      <div class="mobile-text-helper">
        {{ `of ${lastPage}`}}
      </div>
    </div>
    <PaginationArrowButton
        :disabled="props.currentPage === props.lastPage"
        text="Next"
        @click="handlePageClick(props.currentPage + 1)"
    />
  </div>
</template>

<style scoped>
.pagination-wrapper {
  padding-top: var(--spacing-150);
  display: flex;
  align-items: center;
  justify-content: space-between;

  & .numeric-buttons-wrapper {
    display: flex;
    align-items: center;
    gap: var(--spacing-50);
  }

  & .mobile-text-helper {
    color: var(--clr-grey-500);

    @media screen and (min-width: 768px) {
      display: none;
    }
  }
}
</style>
