async function fetchUsers(id = null, name = null) {
  try {
    const queryParams = new URLSearchParams()
    if (id) queryParams.append('id', id)
    if (name) queryParams.append('name', name)

    const response = await fetch(
      `/api/user/get_users.php?${queryParams.toString()}`,
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
    const response = await fetch(`/api/user/update_user.php?id=${id}`, {
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
