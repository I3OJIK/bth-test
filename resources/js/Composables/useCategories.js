import { ref } from 'vue'
import axios from 'axios'

export function useCategories() {
    const categories = ref([])
    const isLoading = ref(false)

    async function fetchCategories() {
        isLoading.value = true
        try {
            const response = await axios.get('/api/categories')
            categories.value = response.data.data
        } catch (e) {
            console.error(e)
        } finally {
            isLoading.value = false
        }
    }

    return { categories, isLoading, fetchCategories }
}
