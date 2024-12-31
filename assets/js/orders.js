async function fetchUserOrders() {
  try {
    const response = await fetch('/api/orders/get_user_orders.php')
    if (!response.ok) {
      throw new Error('Failed to fetch orders')
    }
    const data = await response.json()
    return data.orders
  } catch (error) {
    console.error('Error fetching orders:', error)
    return []
  }
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

function formatCurrency(amount) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(amount)
}

function renderOrders(orders) {
  const container = document.getElementById('ordersContainer')

  if (!orders || orders.length === 0) {
    container.innerHTML =
      '<p class="text-gray-600">You haven\'t placed any orders yet.</p>'
    return
  }

  const ordersHTML = orders
    .slice(0, 5)
    .map(
      (order) => `
        <div class="order-item">
            <p class="font-semibold">Order #${order.id}</p>
            <p class="text-sm text-gray-600">Date: ${formatDate(
              order.created_at
            )}</p>
            <p class="text-sm text-gray-600">Status: ${
              order.status.charAt(0).toUpperCase() + order.status.slice(1)
            }</p>
            <p class="text-sm text-gray-600">Total: ${formatCurrency(
              order.total_amount
            )}</p>
            <div class="mt-2">
                ${order.items
                  .map(
                    (item) => `
                    <div class="text-sm text-gray-600 ml-4">
                        • ${item.quantity}x ${item.product_name}
                    </div>
                `
                  )
                  .join('')}
            </div>
            <a href="order_details.php?id=${order.id}" 
               class="text-[#FF9800] hover:underline text-sm">View Details</a>
        </div>
    `
    )
    .join('')

  container.innerHTML = ordersHTML
}

// fetch and render orders when the page loads
document.addEventListener('DOMContentLoaded', async () => {
  const orders = await fetchUserOrders()
  renderOrders(orders)
})
