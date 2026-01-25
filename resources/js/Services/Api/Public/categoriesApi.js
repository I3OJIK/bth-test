import axios from 'axios'

export const categoriesApi = {
    async fetchCategories() {
        const response = await axios.get('/categories')
        return response.data.data
    }
}