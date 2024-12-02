function loadCart() {
  const cartContainer = document.getElementById('cart-container')
  const cartSummary = document.getElementById('cart-summary')
  const cartItems = JSON.parse(localStorage.getItem('userCart')) || []

  if (cartItems.length === 0) {
    cartContainer.innerHTML = `
      <div class="text-center py-8">
        <p class="text-xl mb-4">Your cart is empty</p>
        <a href="./products" class="bg-primary text-white py-2 px-4 rounded-full hover:bg-opacity-90 transition duration-300">Start Shopping</a>
      </div>
    `
    cartSummary.innerHTML = ''
  } else {
    let cartHTML = ''
    let totalPrice = 0

    cartItems.forEach((item) => {
      const itemTotal = parseFloat(item.price) * item.quantity
      totalPrice += itemTotal

      cartHTML += `
        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-lg shadow-md mb-4">
          <div class="flex flex-col md:flex-row items-center mb-4 md:mb-0">
            <img src="${item.imageUrl}" alt="${item.name}" class="w-24 h-24 object-cover rounded-md mr-4 mb-4 md:mb-0">
            <div>
              <h2 class="text-lg font-semibold">${item.name}</h2>
              <p class="text-gray-600">${item.description}</p>
              <p class="text-primary font-semibold">LKR ${item.price} x ${item.quantity}</p>
            </div>
          </div>
          <button onclick="removeFromCart('${item.id}')" class="bg-accent text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition duration-300">Remove</button>
        </div>
      `
    })

    cartContainer.innerHTML = cartHTML
    cartSummary.innerHTML = `
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Cart Summary</h2>
        <p class="text-xl">Total: <span class="font-bold text-primary">LKR ${totalPrice.toFixed(
          2
        )}</span></p>
        <a href="./cart?action=checkout">
          <button class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300 mt-4">Proceed to Checkout</button>
        </a>
      </div>
    `
  }
}

function removeFromCart(itemId) {
  let cartItems = JSON.parse(localStorage.getItem('userCart')) || []
  cartItems = cartItems.filter((item) => item.id !== itemId)
  localStorage.setItem('userCart', JSON.stringify(cartItems))
  loadCart()
}

function loadCheckout() {
  const checkoutItems = document.getElementById('checkout-items')
  const checkoutTotal = document.getElementById('checkout-total')
  const cartItems = JSON.parse(localStorage.getItem('userCart')) || []

  let checkoutHTML = ''
  let totalPrice = 0

  cartItems.forEach((item) => {
    const itemTotal = parseFloat(item.price) * item.quantity
    totalPrice += itemTotal

    checkoutHTML += `
      <div class="flex justify-between items-center mb-2">
        <span>${item.name} x ${item.quantity}</span>
        <span>LKR ${itemTotal.toFixed(2)}</span>
      </div>
    `
  })

  checkoutItems.innerHTML = checkoutHTML
  checkoutTotal.innerHTML = `Total: LKR ${totalPrice.toFixed(2)}`

  const checkoutForm = document.getElementById('checkout-form')
  checkoutForm.addEventListener('submit', handleCheckout)
}

function handleCheckout(event) {
  event.preventDefault()

  const formData = new FormData(event.target)
  const orderData = Object.fromEntries(formData.entries())

  orderData.items = JSON.parse(localStorage.getItem('userCart')) || []
  orderData.total = orderData.items.reduce(
    (total, item) => total + parseFloat(item.price) * item.quantity,
    0
  )

  console.log('Order Data:', orderData)

  localStorage.setItem('order', JSON.stringify(orderData))
  localStorage.removeItem('userCart')

  alert('Order placed successfully!')
  window.location.href = './cart'
}

// Load cart or checkout on page load
document.addEventListener('DOMContentLoaded', () => {
  const action = new URLSearchParams(window.location.search).get('action')
  if (action === 'checkout') {
    loadCheckout()
  } else {
    loadCart()
  }
})
