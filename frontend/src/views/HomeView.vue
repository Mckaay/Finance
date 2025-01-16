<script setup>
import Menu from "@/components/menu/Menu.vue";
import ThreeDotsDropdown from "@/components/dropdowns/ThreeDotsDropdown.vue";


const sortOptions = [
  {value: 'edit', label: 'edit'},
  {value: 'oldest', label: 'Oldest'},
  {value: 'atoz', label: 'A to Z'},
  {value: 'ztoa', label: 'Z to A'},
  {value: 'highest', label: 'Highest'},
  {value: 'lowest', label: 'Lowest'}
];

</script>

<template>
  <Menu/>
  <main>
    <ThreeDotsDropdown/>
  </main>
</template>

<style>
</style>