// product-detail.js

document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM Content Loaded')
  // Add to cart
  initializeAddToCart()
  // Product data
  console.log(initializeProductData())
  // Quantity controls
  initializeQuantityControls()
  // Thumbnail functionality
  initializeThumbnails()
})

function initializeQuantityControls() {
  const decreaseButton = document.getElementById('decrease-quantity')
  const increaseButton = document.getElementById('increase-quantity')
  const quantityElement = document.getElementById('quantity')
  const maxQuantityElement = document.getElementById('max-quantity')

  if (
    !decreaseButton ||
    !increaseButton ||
    !quantityElement ||
    !maxQuantityElement
  ) {
    console.log('Quantity control elements not found')
    return
  }

  console.log('Quantity control elements found')
  const currentStockQty = parseInt(maxQuantityElement.value)
  console.log('Max quantity:', currentStockQty)

  let quantity = parseInt(quantityElement.textContent) || 1

  decreaseButton.addEventListener('click', () => {
    console.log('Decrease clicked, current quantity:', quantity)
    if (quantity > 1) {
      quantity--
      quantityElement.textContent = quantity
      increaseButton.disabled = false
      console.log('Quantity decreased to:', quantity)
    }
  })

  increaseButton.addEventListener('click', () => {
    console.log('Increase clicked, current quantity:', quantity)
    if (quantity < currentStockQty) {
      quantity++
      quantityElement.textContent = quantity
      if (quantity >= currentStockQty) {
        increaseButton.disabled = true
      }
      console.log('Quantity increased to:', quantity)
    }
  })
}

function initializeThumbnails() {
  const mainImage = document.getElementById('main-image')
  const thumbnails = document.querySelectorAll('.thumbnail')

  if (mainImage && thumbnails.length > 0) {
    console.log('Thumbnail elements found')
    thumbnails.forEach((thumbnail) => {
      thumbnail.addEventListener('click', () => {
        mainImage.src = thumbnail.src
        console.log('Thumbnail clicked, updating main image')
      })
    })
  }
}
function initializeProductData() {
  const productDataElement = document.getElementById('product-data')

  if (productDataElement) {
    const productId = productDataElement.getAttribute('data-id')
    const price = productDataElement.getAttribute('data-price')
    const name = productDataElement.getAttribute('data-name')
    const imageUrl = productDataElement.getAttribute('data-image-url')
    const description = productDataElement.getAttribute('data-description')

    return {
      id: productId,
      price: price,
      name: name,
      imageUrl: imageUrl,
      description: description,
    }
  } else {
    console.log('Product data element not found')
  }
}

function initializeAddToCart() {
  const addToCartButton = document.getElementById('add-to-cart')
  const quantityElement = document.getElementById('quantity')
  const productData = initializeProductData()

  if (!addToCartButton || !quantityElement || !productData) {
    console.log('Add to cart elements not found')
    return
  }

  // Check if the product is already in the cart
  const userCart = JSON.parse(localStorage.getItem('userCart')) || []
  const existingProduct = userCart.find((item) => item.id === productData.id)

  if (parseInt(quantityElement.textContent) <= 0) {
    addToCartButton.textContent = 'Product Out of Stock'
    addToCartButton.disabled = true
    addToCartButton.classList.add('bg-accent/50', 'cursor-not-allowed')
  }

  if (existingProduct) {
    addToCartButton.textContent = 'Added to cart'
    addToCartButton.disabled = true
    addToCartButton.classList.add('bg-accent/50', 'cursor-not-allowed')
  }

  addToCartButton.addEventListener('click', () => {
    const selectedQty = parseInt(quantityElement.textContent)
    console.log('Adding to cart:', {
      product: productData,
      selectedQty: selectedQty,
    })
    if (selectedQty <= 0) {
      console.log('Invalid quantity')
      return
    }
    updateCart(productData, selectedQty)
    addToCartButton.textContent = 'Added to cart'
    addToCartButton.disabled = true
  })
}
function updateCart(product, quantity) {
  let userCart = JSON.parse(localStorage.getItem('userCart')) || []

  const existingProductIndex = userCart.findIndex(
    (item) => item.id === product.id
  )

  if (existingProductIndex !== -1) {
    userCart[existingProductIndex].quantity += quantity
  } else {
    userCart.push({ ...product, quantity: quantity })
  }

  localStorage.setItem('userCart', JSON.stringify(userCart))
}
