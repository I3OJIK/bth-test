<template>
  <AppLayout>
    <div class="container mx-auto px-4 py-8">
      <div v-if="isLoading" class="text-center py-10">
        Загрузка...
      </div>

      <div v-else-if="product">
        <h1 class="text-3xl font-bold mb-4">{{ product.name }}</h1>

        <div class="mb-2">
          <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
            {{ product.category?.name || 'Без категории' }}
          </span>
        </div>

        <p class="text-2xl font-bold text-gray-900 mb-4">{{ formatPrice(product.price) }}</p>


        <p class="text-gray-700 mb-6">
          <strong>Описание:</strong>
          {{ product.description || 'Описание отсутствует' }}
        </p>

        <Link href="/" class="text-blue-600 hover:text-blue-800">
        ← Вернуться к списку товаров
        </Link>
      </div>

      <div v-else class="text-center py-10 text-red-600">
        Товар не найден.
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { useProducts } from '@/Composables/useProducts'

const { getProductById } = useProducts()

const product = ref(null)
const isLoading = ref(true)

const props = defineProps({
  productId: Number
})


function formatPrice(price) {
  if (price == null) return '—'
  return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(price)
}

async function getProduct() {
  isLoading.value = true
  try {
    const response = await getProductById(props.productId)
    product.value = response.data
  } catch (error) {
    console.error('Ошибка загрузки товара:', error)
    product.value = null
  } finally {
    isLoading.value = false
  }
}

onMounted(async () => {
  await getProduct()
})
</script>
