<script setup>
import ThreeDotsIcon from "@/components/shared/icons/ThreeDotsIcon.vue";
import { ref } from "vue";

defineProps({
  options: {
    type: [Array],
    default: () => [],
  },
});

const toggle = ref(false);

const handleOptionClick = (type) => {
  toggle.value = false;

  if (type === "edit") {
    emit("edit");
  }

  if (type === "delete") {
    emit("delete");
  }
};

const emit = defineEmits(["edit", "delete"]);
</script>

<template>
  <div class="dropdown-wrapper">
    <ThreeDotsIcon @click="toggle = !toggle" />
    <ul v-if="toggle">
      <li @click="handleOptionClick('edit')">Edit</li>
      <li @click="handleOptionClick('delete')">Delete</li>
    </ul>
  </div>
</template>

<style scoped>
.dropdown-wrapper {
  position: relative;

  ul {
    font-weight: var(--fw-400);
    position: absolute;
    right: 0;
    display: inline-flex;
    gap: var(--spacing-75);
    flex-direction: column;
    list-style-type: none;
    color: var(--clr-grey-900);
    font-size: var(--fs-87);
    padding: var(--spacing-75) var(--spacing-125);
    border-radius: var(--spacing-50);
    background-color: var(--clr-white);
    box-shadow: 0px 4px 24px 0px rgba(0, 0, 0, 0.25);

    & li {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-75);
    }

    & li:not(:last-child):after {
      content: "";
      width: 100%;
      height: 1px;
      background-color: var(--clr-grey-100);
    }

    & li:hover {
      cursor: pointer;
    }

    & li:last-child {
      color: var(--clr-red);
    }
  }
}
</style>
