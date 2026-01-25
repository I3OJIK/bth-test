<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <ProductCard v-for="product in products" :key="product.id" :product="product">
      <!-- прокидываем слоты дальше -->
      <template #actions="{ product: slotProduct }">
        <slot name="actions" :product="slotProduct" />
      </template>
    </ProductCard>
  </div>

</template>

<script setup>
import { defineProps } from 'vue'
import ProductCard from './ProductCard.vue'

const props = defineProps({
  products: Array,
})

// const emit = defineEmits(['editProduct', 'deleteProduct'])

// function editProduct($event) {
//   emit('editProduct', $event)
// }

// function deleteProduct($event) {
//   emit('editProduct', $event)
// }


</script>