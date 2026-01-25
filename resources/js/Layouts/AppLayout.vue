<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">

        <!-- HEADER -->
        <header class="bg-white border-b">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <Link href="/" class="text-xl font-bold">
                    My Shop
                </Link>

                <nav class="space-x-4">
                    <Button label="Выйти" variant="text" rounded>
                        <i class="pi pi-shopping-cart"></i>
                        <Link href="/">
                            Каталог
                        </Link>
                    </Button>
                    <template v-if="!isAuthenticated">
                        <Button label="Выйти" variant="text" rounded >
                            <i class="pi pi-user"></i>
                            <Link href="/login">
                                Войти
                            </Link>
                        </Button>
                    </template>
                    
                    <template v-else>
                        <Button label="Выйти" variant="text" rounded >
                            <i class="pi pi-sliders-h"></i>
                            <Link href="/admin/products">
                                Управление товарами
                            </Link>
                        </Button>
                        <Button @click="logout" label="Выйти" icon="pi pi-user" severity="danger" variant="text" rounded />
                    </template>
                </nav>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1">
            <Toast />
            <slot />
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-t mt-8">
            <div class="container mx-auto px-4 py-4 text-center text-sm text-gray-500">
                © {{ new Date().getFullYear() }} My Shop
            </div>
        </footer>

    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'
import Toast from 'primevue/toast'

const { isAuthenticated, logout } = useAuth()
</script>