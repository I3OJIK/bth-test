import { ref, watch } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

export function useAuth() {
  const token = ref(localStorage.getItem('token') || null)
  const isAuthenticated = ref(!!token.value)
  const loading = ref(false)
  const error = ref(null)

  // динамическая установка заголовка
  axios.interceptors.request.use(
    (config) => {
      const storedToken = localStorage.getItem('token')
      if (storedToken) {
        config.headers.Authorization = `Bearer ${storedToken}`
      } else {
        delete config.headers.Authorization
      }
      return config
    },
    (err) => Promise.reject(err)
  )


  watch(token, (newToken) => {
    isAuthenticated.value = !!newToken
    if (!newToken) {
      router.visit('/login') // редирект на логин при logout
    }
  })

  // Вход
  async function login(email, password) {
    loading.value = true
    error.value = null

    try {
      const response = await axios.post('/login', { email, password })

      token.value = response.data.token
      localStorage.setItem('token', token.value)
      
      // После входа редирект на защищённый маршрут
      router.visit('/admin/products')
    } catch (e) {
      error.value = e.response?.data?.message || 'Ошибка авторизации'
    } finally {
      loading.value = false
    }
  }

  // Выход
  function logout() {
    token.value = null
    localStorage.removeItem('token')
  }

  return {
    token,
    isAuthenticated,
    loading,
    error,
    login,
    logout
  }
}