<template>
    <AppLayout>
        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div v-if="!isAuthenticated" class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-center">Вход в систему</h2>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label for="email">Email</label>
                        <InputText id="email" type="text" class="w-full" v-model="email" />
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="password">Password</label>
                        <InputText id="password" type="password" class="w-full" v-model="password" />
                    </div>

                    <Button label="Login" icon="pi pi-user" class="w-full mt-3" :loading="loading" @click="submit" />
                    <p v-if="error" class="text-red-600 mt-2 text-sm text-center">{{ error }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useAuth } from '@/Composables/useAuth'

const email = ref('')
const password = ref('')

const { login, loading, error, isAuthenticated } = useAuth()

function submit() {
  login(email.value, password.value)
}
</script>