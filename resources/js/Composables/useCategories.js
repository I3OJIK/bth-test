import { ref } from 'vue'
import { categoriesApi } from '@/Services/Api/Public/categoriesApi'

export function useCategories() {
    const categories = ref([])
    const isLoading = ref(false)
    const error = ref(null)

    async function fetchCategories() {
        isLoading.value = true
        error.value = null
        
        try {
            const data = await categoriesApi.fetchCategories()
            categories.value = data
            return { success: true, data }
        } catch (e) {
            error.value = e.response?.data?.message
            console.error('Ошибка загрузки категорий:', e)
            return { success: false, error: e.response?.data?.message }
        } finally {
            isLoading.value = false
        }
    }

    return { categories, isLoading, error, fetchCategories }
}
