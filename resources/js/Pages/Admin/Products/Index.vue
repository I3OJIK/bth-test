<template>
    <AppLayout>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Управление товарами</h1>
            <div class="flex gap-4 mt-4 justify-between items-center">
                <CategoryFilter :categories="categories" :isLoading="isLoading" :selectedCategory="selectedCategory"
                    @handleCategoryChange="handleCategoryChange"></CategoryFilter>

                <Button label="Редактировать" variant="text" rounded>
                    <i class="pi pi-plus"></i>
                    <Link href="/products/create" class="flex items-center gap-2 ">
                        Добавить товар
                    </Link>
                </Button>
            </div>

            <!-- Список товаров -->
            <ProductList :products="products.data">
                <template #actions="{ product }">
                    <div class="flex gap-4 mt-4 justify-between">
                        <Button label="Редактировать" severity="warn" variant="text" rounded>
                            <i class="pi pi-pencil"></i>
                            <Link :href="`/products/${product.id}/edit`" class="flex items-center gap-2">
                                Редактировать
                            </Link>
                        </Button>

                        <Button @click="handleDeleteProduct(product)" icon="pi pi-trash" label="Удалить"
                            severity="danger" variant="text" rounded />

                    </div>
                </template>
            </ProductList>

            <Pagination :links="paginationLinks" :isLoading="isLoading" :meta="products.meta"
                @changePage="changeByLink" />

        </div>
    </AppLayout>
</template>

<script setup>
import { onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
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
    deleteProduct
} = useProducts()

const { read } = useUrlState()

const { changeByLink } = usePagination(fetchProducts)

function handleCategoryChange(category) {
    selectedCategory.value = category
    fetchProducts(1)
}

async function handleDeleteProduct(product) {
    if (!confirm(`Удалить "${product.name}"?`)) return

    //читаем текущую страницу
    const page = read()

    const result = await deleteProduct(product.id, page)
    if (result?.success) {
        console.log('Товар удален:', result.productId)
    } else if (result?.error) {
        alert(result.error)
    }
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