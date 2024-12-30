// Fetch configuration
const fetchConfig = async () => {
  const response = await fetch('./config.json')
  const config = await response.json()
  return config
}

// Load config immediately
fetchConfig()
  .then((config) => {
    baseUrl = config.env === 'development' ? 'http://localhost/pawsome' : ''
  })
  .catch((error) => {
    console.error('Failed to load configuration:', error)
  })

document.addEventListener('DOMContentLoaded', function () {
  const filterForm = document.getElementById('filter-form')
  const searchInput = document.getElementById('search')
  const categoryInputs = document.querySelectorAll('input[name="category"]')
  const minPriceInput = document.getElementById('min-price')
  const maxPriceInput = document.getElementById('max-price')
  const filterParameters = document.getElementById('filter-parameters')
  const resetFilters = document.getElementById('reset-filters')

  // Reset filters
  resetFilters.addEventListener('click', function (e) {
    e.preventDefault()
    window.location.href = './products'
  })

  filterForm.addEventListener('submit', function (event) {
    event.preventDefault()

    const search = searchInput.value.trim()
    const categorySelect = document.querySelector('select[name="category"]')
    const category = categorySelect.value
    const minPrice = minPriceInput.value.trim()
    const maxPrice = maxPriceInput.value.trim()

    const params = new URLSearchParams()

    // Only append parameters if they have values
    if (search !== '') params.append('search', search)
    if (category !== '') params.append('category_id', category)
    if (minPrice !== '') params.append('min_price', minPrice)
    if (maxPrice !== '') params.append('max_price', maxPrice)
    params.append('page', 1)

    window.location.href = `${baseUrl}/products?${params.toString()}`
  })

  // Set form values from URL parameters
  const searchQuery = filterParameters.dataset.search
  const categoryId = filterParameters.dataset.category
  const minPrice = filterParameters.dataset.minPrice
  const maxPrice = filterParameters.dataset.maxPrice

  // Set initial values if they exist
  if (searchQuery) searchInput.value = searchQuery
  if (categoryId) {
    const categoryInput = [...categoryInputs].find(
      (input) => input.value === categoryId
    )
    if (categoryInput) categoryInput.checked = true
  }
  if (minPrice) minPriceInput.value = minPrice
  if (maxPrice) maxPriceInput.value = maxPrice
})
