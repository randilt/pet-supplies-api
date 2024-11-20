// product-detail.js

document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM Content Loaded')

  // Mobile menu functionality

  // Quantity controls
  initializeQuantityControls()

  // Thumbnail functionality
  initializeThumbnails()
})

function initializeMobileMenu() {
  const mobileMenuButton = document.getElementById('mobile-menu-button')
  const mobileMenu = document.getElementById('mobile-menu')

  if (mobileMenuButton && mobileMenu) {
    console.log('Mobile menu elements found')
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden')
    })
  }
}

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
