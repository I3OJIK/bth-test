<template>
  <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ product.name }}</h3>
    <div class="mb-2">
      <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
        {{ product.category?.name || 'Без категории' }}
      </span>
    </div>
    <p class="text-2xl font-bold text-gray-900 mb-3">{{ formatPrice(product.price) }}</p>
    <p class="text-gray-600 mb-4 line-clamp-2">{{ product.description || 'Нет описания' }}</p>
    <Link :href="`/product/${product.id}`" class="inline-block text-blue-600 hover:text-blue-800 font-medium">
      Подробнее →
    </Link>

    <!-- Слот для действий -->
    <slot name="actions" :product="product">
    </slot>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  product: Object,
})

function formatPrice(price) {
  if (!price && price !== 0) return '—'
  return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(price)
}
</script>