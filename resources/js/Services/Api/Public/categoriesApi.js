import axios from 'axios'

const apiClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

export const categoriesApi = {
    async fetchCategories() {
        const response = await apiClient.get('/categories')
        return response.data.data
    }
}