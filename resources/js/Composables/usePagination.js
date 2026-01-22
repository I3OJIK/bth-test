import { ref } from 'vue'
import { useUrlState } from './useUrlState'

export function usePagination(onChange) {
  const currentPage = ref(1)
  const { extractPage } = useUrlState()

  function changeByLink(url) {
    const page = extractPage(url)
    currentPage.value = page
    onChange(page)
  }

  function change(page) {
    currentPage.value = page
    onChange(page)
  }

  return {
    currentPage,
    change,
    changeByLink
  }
}
