export function useUrlState() {

    //  читает из юрл фильтрацию 
    function read() {
      const params = new URLSearchParams(window.location.search)
  
      return {
        category: params.get('category') || '',
        page: params.has('page') ? Number(params.get('page')) : 1
      }
    }
  
    //записывает в юрл выбранную фильтрацию (выбранная категория и страница)
    function write({ category, page }) {
      const params = new URLSearchParams()
  
      if (category) params.set('category', category)
      if (page && page > 1) params.set('page', page)
  
      const query = params.toString()
      const url = query
        ? `${window.location.pathname}?${query}`
        : window.location.pathname
  
      window.history.replaceState(null, '', url)
    }
  
    function extractPage(url) {
      if (!url) return 1
      return Number(new URL(url).searchParams.get('page') || 1)
    }
  
    return {
      read,
      write,
      extractPage
    }
  }
  