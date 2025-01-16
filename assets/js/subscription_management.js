document.addEventListener('DOMContentLoaded', initializeSubscriptionManagement)

async function initializeSubscriptionManagement() {
  try {
    await fetchSubscriptionPlans()
    await fetchUserSubscriptions()
    setupEventListeners()
  } catch (error) {
    console.error('Initialization failed:', error)
    showError('Failed to initialize subscription management')
  }
}

function setupEventListeners() {
  document
    .getElementById('createSubscriptionBtn')
    .addEventListener('click', showCreateSubscriptionModal)
}

function showError(message) {
  Swal.fire('Error', message, 'error')
}

function fetchSubscriptionPlans() {
  fetch('/api/v1/subscriptions.php?endpoint=plans')
    .then((response) => response.json())
    .then((data) => {
      if (data.plans && data.plans.length > 0) {
        const plansHtml = data.plans
          .map(
            (plan) => `
                    <tr>
                        <td class="py-2 px-4 border-b">${plan.id}</td>
                        <td class="py-2 px-4 border-b">${plan.name}</td>
                        <td class="py-2 px-4 border-b">${plan.description}</td>
                        <td class="py-2 px-4 border-b">LKR ${parseFloat(
                          plan.price
                        ).toFixed(2)}</td>
                        <td class="py-2 px-4 border-b">${
                          plan.duration_months
                        }</td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="editSubscriptionPlan(${
                              plan.id
                            })" class="text-blue-500 hover:underline mr-2">Edit</button>
                            <button onclick="deleteSubscriptionPlan(${
                              plan.id
                            })" class="text-red-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                `
          )
          .join('')
        document.getElementById('subscriptionPlansTableBody').innerHTML =
          plansHtml
      } else {
        document.getElementById('subscriptionPlansTableBody').innerHTML = `
                    <tr>
                        <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">No subscription plans found.</td>
                    </tr>
                `
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      document.getElementById('subscriptionPlansTableBody').innerHTML = `
                <tr>
                    <td colspan="6" class="py-4 px-4 border-b text-center text-red-500">Error loading subscription plans. Please try again.</td>
                </tr>
            `
    })
}

function fetchUserSubscriptions() {
  fetch('/api/v1/subscriptions.php?endpoint=active')
    .then((response) => response.json())
    .then((data) => {
      if (data.subscriptions && data.subscriptions.length > 0) {
        const subscriptionsHtml = data.subscriptions
          .map(
            (subscription) => `
                    <tr>
                        <td class="py-2 px-4 border-b">${subscription.id}</td>
                        <td class="py-2 px-4 border-b">${subscription.user_id}</td>
                        <td class="py-2 px-4 border-b">${subscription.plan_name}</td>
                        <td class="py-2 px-4 border-b">${subscription.start_date}</td>
                        <td class="py-2 px-4 border-b">${subscription.end_date}</td>
                        <td class="py-2 px-4 border-b">${subscription.status}</td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="cancelSubscription(${subscription.id})" class="text-red-500 hover:underline">Cancel</button>
                        </td>
                    </tr>
                `
          )
          .join('')
        document.getElementById('userSubscriptionsTableBody').innerHTML =
          subscriptionsHtml
      } else {
        document.getElementById('userSubscriptionsTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" class="py-4 px-4 border-b text-center text-gray-500">No user subscriptions found.</td>
                    </tr>
                `
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      document.getElementById('userSubscriptionsTableBody').innerHTML = `
                <tr>
                    <td colspan="7" class="py-4 px-4 border-b text-center text-red-500">Error loading user subscriptions. Please try again.</td>
                </tr>
            `
    })
}

function showCreateSubscriptionModal() {
  Swal.fire({
    title: 'Create New Subscription Plan',
    html: `
            <input id="planName" class="swal2-input" placeholder="Plan Name">
            <input id="planDescription" class="swal2-input" placeholder="Description">
            <input id="planPrice" class="swal2-input" placeholder="Price">
            <input id="planDuration" class="swal2-input" placeholder="Duration (Months)">
        `,
    focusConfirm: false,
    preConfirm: () => {
      return {
        name: document.getElementById('planName').value,
        description: document.getElementById('planDescription').value,
        price: document.getElementById('planPrice').value,
        duration_months: document.getElementById('planDuration').value,
      }
    },
  }).then((result) => {
    if (result.isConfirmed) {
      createSubscriptionPlan(result.value)
    }
  })
}

function createSubscriptionPlan(planData) {
  fetch('/api/v1/subscriptions.php?endpoint=plans', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(planData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        Swal.fire(
          'Success',
          'Subscription plan created successfully',
          'success'
        )
        fetchSubscriptionPlans()
      } else {
        Swal.fire(
          'Error',
          data.message || 'Failed to create subscription plan',
          'error'
        )
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      Swal.fire(
        'Error',
        'An error occurred while creating the subscription plan',
        'error'
      )
    })
}

function editSubscriptionPlan(planId) {
  fetch(`/api/v1/subscriptions.php?endpoint=plans&id=${planId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.plan) {
        Swal.fire({
          title: 'Edit Subscription Plan',
          html: `
                        <input id="planName" class="swal2-input" value="${data.plan.name}">
                        <input id="planDescription" class="swal2-input" value="${data.plan.description}">
                        <input id="planPrice" class="swal2-input" value="${data.plan.price}">
                        <input id="planDuration" class="swal2-input" value="${data.plan.duration_months}">
                    `,
          focusConfirm: false,
          preConfirm: () => {
            return {
              name: document.getElementById('planName').value,
              description: document.getElementById('planDescription').value,
              price: document.getElementById('planPrice').value,
              duration_months: document.getElementById('planDuration').value,
            }
          },
        }).then((result) => {
          if (result.isConfirmed) {
            updateSubscriptionPlan(planId, result.value)
          }
        })
      } else {
        Swal.fire('Error', 'Failed to fetch subscription plan details', 'error')
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      Swal.fire(
        'Error',
        'An error occurred while fetching the subscription plan details',
        'error'
      )
    })
}

function updateSubscriptionPlan(planId, planData) {
  fetch(`/api/v1/subscriptions.php?endpoint=plans&id=${planId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(planData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        Swal.fire(
          'Success',
          'Subscription plan updated successfully',
          'success'
        )
        fetchSubscriptionPlans()
      } else {
        Swal.fire(
          'Error',
          data.message || 'Failed to update subscription plan',
          'error'
        )
      }
    })
    .catch((error) => {
      console.error('Error:', error)
      Swal.fire(
        'Error',
        'An error occurred while updating the subscription plan',
        'error'
      )
    })
}

function deleteSubscriptionPlan(planId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/api/v1/subscriptions.php?endpoint=plans&id=${planId}`, {
        method: 'DELETE',
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire(
              'Deleted!',
              'Subscription plan has been deleted.',
              'success'
            )
            fetchSubscriptionPlans()
          } else {
            Swal.fire(
              'Error',
              data.message || 'Failed to delete subscription plan',
              'error'
            )
          }
        })
        .catch((error) => {
          console.error('Error:', error)
          Swal.fire(
            'Error',
            'An error occurred while deleting the subscription plan',
            'error'
          )
        })
    }
  })
}

function cancelSubscription(subscriptionId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This will cancel the user's subscription!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, cancel it!',
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/api/v1/subscriptions.php?id=${subscriptionId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: 'cancelled' }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire(
              'Cancelled!',
              'The subscription has been cancelled.',
              'success'
            )
            fetchUserSubscriptions()
          } else {
            Swal.fire(
              'Error',
              data.message || 'Failed to cancel subscription',
              'error'
            )
          }
        })
        .catch((error) => {
          console.error('Error:', error)
          Swal.fire(
            'Error',
            'An error occurred while cancelling the subscription',
            'error'
          )
        })
    }
  })
}
