import { ref, computed } from 'vue'
import { productsApi } from '@/Services/Api/Public/productsApi'
import { adminProductsApi } from '@/Services/Api/Admin/productsApi'
import { useUrlState } from './useUrlState'
import { useAuth } from './useAuth'

export function useProducts() {
    const auth = useAuth()
    
    // Состояние
    const products = ref({ data: [], meta: {}})
    const isLoading = ref(false)
    const isDeleting = ref(false)
    const isSaving = ref(false)
    const selectedCategory = ref('')
    const { write } = useUrlState()
    
    const paginationLinks = computed(() => products.value.meta?.links || [])
    const isAuthenticated = computed(() => auth.isAuthenticated.value) 
    
    // публичные методы
    async function fetchProducts(page = 1) {
        isLoading.value = true
        try {
            const params = { page }
            if (selectedCategory.value) {
                params.category = selectedCategory.value
            }
            const data = await productsApi.getAll(params)
            products.value = data

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

    async function getProductById(id) {
        try {
            return await productsApi.getById(id)
        } catch (error) {
            console.error('Ошибка загрузки товара:', error)
            throw error
        }
    }

    // Защищенные методы (доступны только авторизованным)
    async function deleteProduct(productId, page) {
        if (!isAuthenticated.value) {
            console.warn('Требуется авторизация')
            return { error: 'Требуется авторизация' }
        }
        

        
        isDeleting.value = true
        try {
             await adminProductsApi.delete(productId)
            
            // Удаляем из локального списка
            await fetchProducts(page)
            
            return { success: true, productId: productId }
            
        } catch (error) {
            console.error('Ошибка удаления:', error)
            return { error: error.message }
        } finally {
            isDeleting.value = false
        }
    }

    async function updateProduct(productId, data) {
        if (!isAuthenticated.value) {
            console.warn('Требуется авторизация')
            return { error: 'Требуется авторизация' }
        }
        
        isSaving.value = true
        try {
            const result = await adminProductsApi.update(productId, data)
            
            // Обновляем в локальном списке
            const index = products.value.data.findIndex(p => p.id === productId)
            if (index !== -1) {
                products.value.data[index] = { ...products.value.data[index], ...data }
            }
            
            return { success: true, data: result }
            
        } catch (error) {
            console.error('Ошибка обновления:', error)
            return { error: error.message }
        } finally {
            isSaving.value = false
        }
    }
    
    async function createProduct(data) {
        if (!isAuthenticated.value) {
            console.warn('Требуется авторизация')
            return { error: 'Требуется авторизация' }
        }
        
        isSaving.value = true
        try {
            const result = await adminProductsApi.create(data)
            return { success: true, data: result }
        } catch (error) {
            console.error('Ошибка создания:', error)
            return { error: error.message }
        } finally {
            isSaving.value = false
        }
    }

    return {
        // State
        products,
        isLoading,
        isDeleting,
        isSaving,
        selectedCategory,
        
        // Computed
        paginationLinks,
        isAuthenticated,
        
        // Публичные методы
        fetchProducts,
        getProductById,
        
        // Защищенные методы
        deleteProduct,
        updateProduct,
        createProduct,
    }
}
