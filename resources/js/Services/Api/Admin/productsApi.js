import axios from 'axios'

export const adminProductsApi = {
    async create(productData) {
        const response = await axios.post('/products', productData)
        return response.data
    },
    
    async update(id, productData) {
        const response = await axios.put(`/products/${id}`, productData)
        return response.data
    },
    
    async delete(id) {
        const response = await axios.delete(`/products/${id}`)
        return response.data
    }
}