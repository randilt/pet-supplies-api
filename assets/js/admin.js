document.addEventListener('DOMContentLoaded', function () {
  // Price distribution chart
  var ctx = document.getElementById('priceChart').getContext('2d')
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['$0-$50', '$51-$100', '$101-$500', '$501-$1000', '$1000+'],
      datasets: [
        {
          label: 'Number of Products',
          data: [2, 1, 1, 1, 1], // Replace with actual data
          backgroundColor: '#FF9800',
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  })
  const productForm = document.getElementById('productForm')

  productForm.onsubmit = async function (e) {
    e.preventDefault()

    // Create FormData object from the form
    const formData = new FormData(productForm)

    // Create the product data object with the required fields
    const productData = {
      category_id: parseInt(formData.get('category_id')),
      name: formData.get('name'),
      description: formData.get('description'),
      long_description: formData.get('long_description'),
      price: parseFloat(formData.get('price')),
      stock_quantity: parseInt(formData.get('stock_quantity')),
    }

    try {
      const imageFile = formData.get('product_image')
      if (imageFile && imageFile.size > 0) {
        //have to handle image upload
      }

      // Make the API call with JSON data
      const response = await fetch(
        'http://localhost/pawsome/api/products/add_product.php',
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(productData),
        }
      )

      const data = await response.json()

      if (!response.ok) {
        throw new Error(
          data.error || data.errors?.join(', ') || 'Failed to add product'
        )
      }

      alert('Product added successfully')
      productForm.reset()

      console.log('Product added:', data)
    } catch (error) {
      alert('Error: ' + error.message)
      console.error('Error:', error)
    }
  }
})
