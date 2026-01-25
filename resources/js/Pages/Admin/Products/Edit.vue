<template>
    <AppLayout>
      <ProductForm :product="product" />
    </AppLayout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import AppLayout from '@/Layouts/AppLayout.vue'
  import ProductForm from '@/Components/ProductForm.vue'
  import { useProducts } from '@/Composables/useProducts'
  
  const props = defineProps({
    productId: Number // передаем через Inertia props
  })
  
  const product = ref()
  const { getProductById } = useProducts()
  const isLoading = ref(true)
  
  onMounted(async () => {
    try {
      const response = await getProductById(props.productId)
      product.value = response.data
    } catch (e) {
      console.error('Ошибка загрузки продукта:', e)
    } finally {
      isLoading.value = false
    }
  })
  </script>
  