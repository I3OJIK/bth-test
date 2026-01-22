<!-- resources/js/Pages/Product/Show.vue -->
<template>
    <div>
      <h1>{{ product.name }}</h1>
      <p>Цена: {{ product.price }}</p>
      <p>Описание: {{ product.description }}</p>
      <p>Категория: {{ product.category?.name }}</p>
      
      <Link href="/">Назад к списку</Link>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  
  const props = defineProps({
    product: Object
  })
  </script>