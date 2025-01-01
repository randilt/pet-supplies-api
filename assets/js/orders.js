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

function getStatusBadge(status) {
  const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    shipped: 'bg-purple-100 text-purple-800',
    delivered: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
  }

  return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
    statusColors[status]
  }">
    ${status.charAt(0).toUpperCase() + status.slice(1)}
  </span>`
}

function renderOrders(orders) {
  const container = document.getElementById('ordersContainer')

  if (!orders || orders.length === 0) {
    container.innerHTML =
      '<p class="text-gray-600">You haven\'t placed any orders yet.</p>'
    return
  }

  const ordersHTML = orders
    .map(
      (order) => `
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
          <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Order #${
              order.id
            }</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Placed on ${formatDate(
              order.created_at
            )}</p>
          </div>
          <div>
            ${getStatusBadge(order.status)}
          </div>
        </div>
        <div class="border-t border-gray-200">
          <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">${formatCurrency(
                order.total_amount
              )} - Cash on delivery</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">${
                order.shipping_address
              }</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Items</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                  ${order.items
                    .map(
                      (item) => `
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                      <div class="w-0 flex-1 flex items-center">
                        <span class="ml-2 flex-1 w-0 truncate">${
                          item.quantity
                        }x ${item.product_name}</span>
                      </div>
                      <div class="ml-4 flex-shrink-0">
                        <span class="font-medium">${formatCurrency(
                          item.price_at_time * item.quantity
                        )}</span>
                      </div>
                    </li>
                  `
                    )
                    .join('')}
                </ul>
              </dd>
            </div>
          </dl>
        </div>


        <div class="bg-white px-4 py-4 sm:px-6 flex justify-end">
    
        </div>
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
