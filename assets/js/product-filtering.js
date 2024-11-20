document.addEventListener('DOMContentLoaded', function () {
  const filterForm = document.getElementById('filter-form')
  const searchInput = document.getElementById('search')
  const categoryInputs = document.querySelectorAll('input[name="category"]')
  const minPriceInput = document.getElementById('min-price')
  const maxPriceInput = document.getElementById('max-price')
  const filterParameters = document.getElementById('filter-parameters')

  filterForm.addEventListener('submit', function (event) {
    event.preventDefault()

    const search = searchInput.value.trim()
    const category = [...categoryInputs].find((input) => input.checked)?.value
    const minPrice = minPriceInput.value.trim()
    const maxPrice = maxPriceInput.value.trim()

    const params = new URLSearchParams()

    // Only append parameters if they have values
    if (search !== '') params.append('search', search)
    if (category) params.append('category_id', category)
    if (minPrice !== '') params.append('min_price', minPrice)
    if (maxPrice !== '') params.append('max_price', maxPrice)

    window.location.href = `http://localhost/pawsome/products?${params.toString()}`
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
