<template>
  <div v-if="links.length > 0" class="mt-8 flex flex-wrap justify-center gap-1">
    <button v-for="link in links" :key="link.label" @click="changePage(link)" :disabled="!link.url || isLoading"
      class="px-3 py-1 border rounded min-w-[40px] flex items-center justify-center transition-colors" :class="{
        'bg-blue-600 text-white border-blue-600': link.active,
        'opacity-50 cursor-not-allowed': !link.url || isLoading,
        'hover:bg-gray-100': link.url && !link.active && !isLoading,
        'text-gray-400': link.label === '...'
      }" v-html="link.label" />
  </div>
<!-- Информация о странице -->
  <div v-if="meta" class="mt-4 text-center text-sm text-gray-500">
    Страница {{ meta.current_page }} из {{meta.last_page }}
    • Показано {{ meta.from }}-{{meta.to }} из {{meta.total }}
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  links: Array,
  isLoading: Boolean,
  meta: Object
})

const emit = defineEmits(['changePage'])

function changePage(link) {
  emit('changePage', link.url)
}

</script>