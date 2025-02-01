document.addEventListener('DOMContentLoaded', initializeApp)

async function initializeApp() {
  try {
    await fetchOrders()
  } catch (error) {
    console.error('Initialization failed:', error)
    showError('Failed to initialize application')
  }
}

function showError(message) {
  document.getElementById('ordersTableBody').innerHTML = `
        <tr>
            <td colspan="6" class="py-4 px-4 border-b text-center text-red-500">${message}</td>
        </tr>
    `
}

function getStatusClass(status) {
  const statusClasses = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    shipped: 'bg-purple-100 text-purple-800',
    delivered: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
  }
  return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

function fetchOrders() {
  fetch(`/api/v1/orders.php`)
    .then((response) => response.json())
    .then((data) => {
      if (data.orders && data.orders.length > 0) {
        const ordersHtml = data.orders
          .map(
            (order) => `
                    <tr>
                        <td class="py-2 px-4 border-b">${order.id}</td>
                        <td class="py-2 px-4 border-b">${order.user_id}</td>
                        <td class="py-2 px-4 border-b">LKR ${parseFloat(
                          order.total_amount
                        ).toFixed(2)}</td>
                        <td class="py-2 px-4 border-b">
                            <span id="status-${
                              order.id
                            }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(
              order.status
            )}">
                                ${
                                  order.status.charAt(0).toUpperCase() +
                                  order.status.slice(1)
                                }
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">${order.created_at}</td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="viewOrderDetails(${order.id})"
                                class="text-blue-500 hover:underline mr-2">View</button>
                            <button onclick="updateOrderStatus(${order.id})"
                                class="text-green-500 hover:underline">Update Status</button>
                        </td>
                    </tr>
                `
          )
          .join('')
        document.getElementById('ordersTableBody').innerHTML = ordersHtml
      } else {
        document.getElementById('ordersTableBody').innerHTML = `
                    <tr>
                        <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">No orders found.</td>
                    </tr>
                `
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      document.getElementById('ordersTableBody').innerHTML = `
                <tr>
                    <td colspan="6" class="py-4 px-4 border-b text-center text-red-500">Error loading orders. Please try again.</td>
                </tr>
            `
    })
}

function viewOrderDetails(orderId) {
  fetch(`${apiUrl}/v1/orders.php`)
    .then((response) => response.json())
    .then((data) => {
      const order = data.orders.find((o) => o.id === orderId)
      if (order) {
        let itemsHtml = order.items
          .map(
            (item) =>
              `<li>${item.quantity}x ${item.product_name} - LKR ${(
                parseFloat(item.price_at_time) * item.quantity
              ).toFixed(2)}</li>`
          )
          .join('')

        Swal.fire({
          title: `Order #${order.id} Details`,
          html: `
                        <p><strong>User ID:</strong> ${order.user_id}</p>
                        <p><strong>Total Amount:</strong> LKR ${parseFloat(
                          order.total_amount
                        ).toFixed(2)}</p>
                        <p><strong>Status:</strong> ${order.status}</p>
                        <p><strong>Shipping Address:</strong> ${
                          order.shipping_address
                        }</p>
                        <p><strong>Created At:</strong> ${order.created_at}</p>
                        <p><strong>Updated At:</strong> ${order.updated_at}</p>
                        <h4 class="mt-4 mb-2 font-bold">Order Items:</h4>
                        <ul class="list-disc pl-5">
                            ${itemsHtml}
                        </ul>
                    `,
          width: 600,
          confirmButtonText: 'Close',
        })
      } else {
        Swal.fire('Error', 'Order not found', 'error')
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      Swal.fire(
        'Error',
        'An error occurred while fetching order details',
        'error'
      )
    })
}

function updateOrderStatus(orderId) {
  Swal.fire({
    title: 'Update Order Status',
    input: 'select',
    inputOptions: {
      pending: 'Pending',
      processing: 'Processing',
      shipped: 'Shipped',
      delivered: 'Delivered',
      cancelled: 'Cancelled',
    },
    inputPlaceholder: 'Select a status',
    showCancelButton: true,
    confirmButtonText: 'Update',
    showLoaderOnConfirm: true,
    preConfirm: (status) => {
      return fetch(`/api/v1/orders.php?id=${orderId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: status }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            return data
          }
          throw new Error(data.message || 'Failed to update order status')
        })
        .catch((error) => {
          Swal.showValidationMessage(`Request failed: ${error}`)
        })
    },
    allowOutsideClick: () => !Swal.isLoading(),
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Success!',
        text: 'Order status has been updated.',
        icon: 'success',
      })
      fetchOrders()
    }
  })
}
