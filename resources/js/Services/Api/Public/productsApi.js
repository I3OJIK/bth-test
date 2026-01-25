import axios from 'axios'

const apiClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

export const productsApi = {
    // Публичные методы (для каталога)
    async getAll(params = {}) {
        const response = await apiClient.get('/products', { params })
        return response.data
    },
    
    async getById(id) {
        const response = await apiClient.get(`/products/${id}`)
        return response.data
    }
}