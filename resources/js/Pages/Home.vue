<template>
    <AppLayout>
      
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Каталог товаров</h1>
            
            <CategoryFilter :categories="categories" :isLoading="isLoading" :selectedCategory="selectedCategory" @handleCategoryChange="handleCategoryChange"></CategoryFilter>

            <!-- Список товаров -->
            <ProductList :products="products.data"  />

            <Pagination :links="paginationLinks" :isLoading="isLoading" :meta="products.meta" @changePage="changeByLink" />
            
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryFilter from '@/Components/CategoryFilter.vue'
import ProductList from '@/Components/ProductList.vue'
import Pagination from '@/Components/Pagination.vue'

import { useProducts } from '@/Composables/useProducts'
import { useCategories } from '@/Composables/useCategories'
import { usePagination } from '@/Composables/usePagination'
import { useUrlState } from '@/Composables/useUrlState'

const { categories, fetchCategories } = useCategories()
const {
  products,
  selectedCategory,
  paginationLinks,
  isLoading,
  fetchProducts,
  isAuthenticated,
} = useProducts()

const { read } = useUrlState()

const { changeByLink } = usePagination(fetchProducts)

function handleCategoryChange(category) {
  selectedCategory.value = category
  fetchProducts(1)
}

onMounted(async () => {
  await fetchCategories()

  const { category, page } = read()
  selectedCategory.value = category

  fetchProducts(page)
})


</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Стили для кнопок пагинации */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>