import axios from 'axios'

const adminApiClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
})

export const adminProductsApi = {
    async create(productData) {
        const response = await adminApiClient.post('/products', productData)
        return response.data
    },
    
    async update(id, productData) {
        const response = await adminApiClient.put(`/products/${id}`, productData)
        return response.data
    },
    
    async delete(id) {
        const response = await adminApiClient.delete(`/products/${id}`)
        return response.data
    }
}