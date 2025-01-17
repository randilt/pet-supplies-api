async function fetchUsers(id = null, name = null) {
  try {
    const queryParams = new URLSearchParams()
    if (id) queryParams.append('id', id)
    if (name) queryParams.append('name', name)

    const response = await fetch(
      `/api/v1/users.php?${queryParams.toString()}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )
    if (!response.ok) {
      throw new Error('Failed to fetch users')
    }
    const data = await response.json()
    // console.log('userdata:', data)
    return data
  } catch (error) {
    console.error('Error fetching users:', error)
    return []
  }
}

async function updateUser(id, name, phone, address) {
  try {
    if (!confirm('Are you sure you want to update your information?')) {
      return
    }
    const response = await fetch(`/api/v1/users.php?id=${id} `, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        name,
        phone,
        address,
      }),
    })
    if (!response.ok) {
      throw new Error('Failed to update user')
    }
    const data = await response.json()
    console.log('userdata:', data)
    return data
  } catch (error) {
    console.error('Error updating user:', error)
    return []
  }
}

async function fetchUserSubscriptions(userId) {
  try {
    const response = await fetch(
      `/api/v1/subscriptions.php?user_id=${userId}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      }
    )
    if (!response.ok) {
      throw new Error('Failed to fetch user subscriptions')
    }
    const data = await response.json()
    return data.subscriptions || []
  } catch (error) {
    console.error('Error fetching user subscriptions:', error)
    return []
  }
}

async function reactivateSubscription(subscriptionId) {
  try {
    const response = await fetch(`/api/v1/subscriptions.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ plan_id: subscriptionId }),
    })
    if (!response.ok) {
      throw new Error('Failed to reactivate subscription')
    }
    const data = await response.json()
    return data.success
  } catch (error) {
    console.error('Error reactivating subscription:', error)
    return false
  }
}

async function cancelSubscription(subscriptionId) {
  try {
    const response = await fetch(
      `/api/v1/subscriptions.php?id=${subscriptionId}`,
      {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: 'cancelled' }),
      }
    )
    if (!response.ok) {
      throw new Error('Failed to cancel subscription')
    }
    const data = await response.json()
    return data.success
  } catch (error) {
    console.error('Error cancelling subscription:', error)
    return false
  }
}

async function handleReactivateSubscription(subscriptionId) {
  if (confirm('Are you sure you want to reactivate this subscription?')) {
    const success = await reactivateSubscription(subscriptionId)
    if (success) {
      alert('Subscription reactivated successfully')
      const userId = document
        .getElementById('userId')
        .getAttribute('data-user-id')
      const subscriptions = await fetchUserSubscriptions(userId)
      displaySubscriptions(subscriptions)
    } else {
      alert('Already have another active subscription!')
    }
  }
}

function displaySubscriptions(subscriptions) {
  const subscriptionsContainer = document.getElementById(
    'subscriptionsContainer'
  )
  if (subscriptions.length === 0) {
    subscriptionsContainer.innerHTML = `
            <p class="text-gray-600">You don't have any active subscriptions.</p>
            <a href="/subscription" class="inline-block mt-4 bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
                Subscribe Now
            </a>
        `
  } else {
    const subscriptionsList = subscriptions
      .slice(0, 3)
      .map(
        (sub) => `
      <div class="bg-white p-4 rounded-md shadow-md">
      <h3 class="text-lg font-bold">${sub.plan_name}</h3>
      <h4 class="text-gray-600 font-bold">Price: Rs. ${sub.plan_price}</h4>
      <p class="text-gray-600">Status: 
        <span class="${
          sub.status === 'active'
            ? 'text-green-500'
            : sub.status === 'cancelled'
            ? 'text-red-500'
            : 'text-yellow-500'
        }">
        ${sub.status.charAt(0).toUpperCase() + sub.status.slice(1)}
        </span>
      </p>
      <p class="text-gray-600">Start Date: ${sub.start_date}</p>
      <p class="text-gray-600">End Date: ${sub.end_date}</p>
      ${
        sub.status === 'active'
          ? `<button onclick="handleCancelSubscription(${sub.id})" class="mt-2 bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
        Cancel Subscription
        </button>`
          : `<button onclick="handleReactivateSubscription(${sub.plan_id})" class="mt-2 bg-green-500 text-white py-1 px-3 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300">
        Reactivate Subscription
        </button>`
      }
      </div>
      `
      )
      .join('')
    subscriptionsContainer.innerHTML = subscriptionsList
  }
}

async function handleCancelSubscription(subscriptionId) {
  if (confirm('Are you sure you want to cancel this subscription?')) {
    const success = await cancelSubscription(subscriptionId)
    if (success) {
      alert('Subscription cancelled successfully')
      const userId = document
        .getElementById('userId')
        .getAttribute('data-user-id')
      const subscriptions = await fetchUserSubscriptions(userId)
      displaySubscriptions(subscriptions)
    } else {
      alert('Failed to cancel subscription. Please try again.')
    }
  }
}

document.addEventListener('DOMContentLoaded', async () => {
  //   const users = await fetchUsers()
  //   console.log('users:', users)
  const userIdElement = document.getElementById('userId')
  const userInfoForm = document.getElementById('userInformationForm')
  const userId = userIdElement
    ? userIdElement.getAttribute('data-user-id')
    : null
  //   console.log('User ID:', userId)
  if (userId) {
    const currentUser = await fetchUsers(userId)
    // console.log('Current user:', currentUser)

    if (currentUser.length > 0) {
      const user = currentUser[0]
      console.log('User:', user)
      document.getElementById('name').value = user.name
      document.getElementById('phone').value = user.phone
      document.getElementById('address').value = user.address
      document.getElementById('email').value = user.email
    }
    const subscriptions = await fetchUserSubscriptions(userId)
    displaySubscriptions(subscriptions)
  }

  userInfoForm.addEventListener('submit', async (event) => {
    event.preventDefault()
    const name = document.getElementById('name')?.value
    const phone = document.getElementById('phone')?.value
    const address = document.getElementById('address')?.value
    console.log('Name:', name)
    console.log('Phone:', phone)
    console.log('Address:', address)
    const updatedUser = await updateUser(userId, name, phone, address)
    console.log('Updated user:', updatedUser)
    // if (!userId || !name || !phone || !address) {
    //   console.error('Invalid user data')
    // } else {
    //
    // }
  })
})
