import { ref, computed } from 'vue'
import axios from 'axios'
import { useUrlState } from './useUrlState'

export function useProducts() {
    const products = ref({ data: [], meta: {}})
    const isLoading = ref(false)
    const selectedCategory = ref('')
    const { write } = useUrlState()

    const paginationLinks = computed(() => {
        return products.value.meta?.links || []
    })

    async function fetchProducts(page = 1) {
        isLoading.value = true
        try {
            const params = { page }
            if (selectedCategory.value) {
                params.category = selectedCategory.value
            }
            const response = await axios.get('/api/products', { params })
            products.value = response.data

            write({
                category: selectedCategory.value,
                page
            })
        } catch (e) {
            console.error(e)
        } finally {
            isLoading.value = false
        }
    }

    return { products, isLoading, fetchProducts, paginationLinks, selectedCategory}
}
