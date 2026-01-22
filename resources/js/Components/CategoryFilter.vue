<template>
    <div class="mb-6 max-w-xs">
      <label class="block text-gray-700 mb-2">Фильтр по категории:</label>
      <select :value="selectedCategory" @change="handleCategoryChange" class="border rounded px-4 py-2 w-full" :disabled="isLoading">
        <option value="">Все категории</option>
        <option v-for="category in categories" :key="category.id" :value="category.name">
          {{ category.name }}
        </option>
      </select>
      <div v-if="isLoading" class="mt-2 text-blue-600 text-sm">Загрузка...</div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue'
  
  const props = defineProps({
    categories: Array,
    selectedCategory: String,
    isLoading: Boolean
  })
  
  const emit = defineEmits(['handleCategoryChange'])
  
  function handleCategoryChange(event) {
    emit('handleCategoryChange', event.target.value)
  }
  </script>
  