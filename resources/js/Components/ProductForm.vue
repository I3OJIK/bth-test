<template>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">{{ isEdit ? 'Редактирование товара' : 'Создание товара' }}</h2>

        <div class="flex flex-col gap-4">
            <!-- Название -->
            <div class="flex flex-col gap-1">
                <label for="name">Название</label>
                <InputText id="name" v-model="form.name" :invalid="errors.name" class="w-full" />
            </div>

            <!-- Категория -->
            <div class="flex flex-col gap-1">
                <label for="category">Категория</label>
                <Select id="category" v-model="form.category_id" :options="categoryOptions" option-label="name"
                    option-value="id" placeholder="Выберите категорию" />
            </div>

            <!-- Цена -->
            <div class="flex flex-col gap-1">
                <label for="price">Цена</label>
                <InputNumber id="price" v-model="form.price" :invalid="errors.price" :min="0" class="w-full" />
            </div>

            <!-- Описание -->
            <div class="flex flex-col gap-1">
                <label for="description">Описание</label>
                <Textarea id="description" :invalid="errors.description" v-model="form.description" rows="4"
                    class="w-full" />
            </div>

            <!-- Кнопки -->
            <div class="flex gap-4 mt-4">
                <Button label="Сохранить" severity="success" @click="submit" :loading="isSaving" />
                <Button label="Отмена" severity="secondary" @click="cancel" />
            </div>

            <p v-if="error" class="text-red-600 mt-2">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { useProducts } from '@/Composables/useProducts'
import { useCategories } from '@/Composables/useCategories'

const props = defineProps({
    product: { type: Object }, // если есть — редактирование
})

const isEdit = computed(() => !!props.product)

const { categories, fetchCategories } = useCategories()
const { createProduct, updateProduct, isSaving } = useProducts()

const errors = ref({
    name: false,
    category_id: false,
    price: false,
    description: false,
})

const form = ref({
    name: '',
    category_id: null,
    price: 0,
    description: ''
})

const error = ref('')

watch(
    () => props.product,
    (product) => {
        if (!product) return

        form.value = {
            name: product.name,
            price: product.price,
            description: product.description,
            category_id: product.category.id,
        }
    }
)


// Заполняем форму при редактировании
onMounted(async () => {
    await fetchCategories()
})

const categoryOptions = computed(() => categories.value || [])

async function submit() {
    error.value = ''

    if (!validate()) {
        error.value = 'Заполните обязательные поля'
        return
    }
    try {
        if (isEdit.value) {
            await updateProduct(props.product.id, form.value)
        } else {
            await createProduct(form.value)
        }
        router.visit('/admin/products', {
            data: { saved: true },
        })
    } catch (e) {
        error.value = e.message || 'Ошибка при сохранении'
    }
}

function validate() {
    errors.value = {
        name: !form.value.name.trim(),
        category_id: !form.value.category_id,
        price: form.value.price <= 0,
        description: !form.value.description,
    }

    return !Object.values(errors.value).some(Boolean)
}

function cancel() {
    router.visit('/admin/products')
}
</script>