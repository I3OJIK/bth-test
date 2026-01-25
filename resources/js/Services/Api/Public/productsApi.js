import axios from 'axios'

export const productsApi = {
    // Публичные методы (для каталога)
    async getAll(params = {}) {
        const response = await axios.get('/products', { params })
        return response.data
    },
    
    async getById(id) {
        const response = await axios.get(`/products/${id}`)
        return response.data
    }
}