<template>
  <div v-if="products.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <ProductCard v-for="product in products" :key="product.id" :product="product" />
  </div>
  <div v-else class="text-center py-12 text-gray-500 text-lg">
    Товары не найдены
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import ProductCard from './ProductCard.vue'

const props = defineProps({
  products: Array
})

</script>