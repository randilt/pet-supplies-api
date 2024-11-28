document.addEventListener('DOMContentLoaded', function () {
  // Price distribution chart
  var priceChartStats = document.getElementById('priceChartStats')
  if (priceChartStats) {
    var dataFrom0to200 = parseInt(
      priceChartStats.getAttribute('data-from0to200')
    )
    var dataFrom201to400 = parseInt(
      priceChartStats.getAttribute('data-from201to400')
    )
    var dataFrom401to600 = parseInt(
      priceChartStats.getAttribute('data-from401to600')
    )
    var dataFrom601to800 = parseInt(
      priceChartStats.getAttribute('data-from601to800')
    )
    var dataFrom2000to5000 = parseInt(
      priceChartStats.getAttribute('data-from2000to5000')
    )
    var dataFrom5000 = parseInt(priceChartStats.getAttribute('data-from5000'))

    console.log(
      dataFrom0to200,
      dataFrom201to400,
      dataFrom401to600,
      dataFrom601to800,
      dataFrom2000to5000,
      dataFrom5000
    )

    var ctx = document.getElementById('priceChart')
    if (ctx) {
      var chart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
          labels: [
            'Rs.0-Rs.200',
            'Rs.201-Rs.400',
            'Rs.401-Rs.600',
            'Rs.601-Rs.800',
            'Rs.2000-Rs.5000',
            'Rs.5000+',
          ],
          datasets: [
            {
              label: 'Number of Products',
              data: [
                dataFrom0to200,
                dataFrom201to400,
                dataFrom401to600,
                dataFrom601to800,
                dataFrom2000to5000,
                dataFrom5000,
              ],
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
    }
  }

  const productForm = document.getElementById('productForm')
  if (productForm) {
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
        image_url: formData.get('image_url') || null,
      }

      try {
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
          Swal.fire({
            title: 'Error!',
            text: data.error || 'Failed to update product',
            icon: 'error',
          })
          throw new Error(
            data.error || data.errors?.join(', ') || 'Failed to add product'
          )
        }
        console.log(data)

        Swal.fire({
          title: 'Success!',
          text: 'Product updated successfully',
          icon: 'success',
          confirmButtonColor: '#3B82F6',
        }).then((result) => {
          if (result.isConfirmed || result.isDismissed) {
            productForm.reset()
            location.reload()
          }
        })

        console.log('Product added:', data)
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error.message || 'Failed to update product',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        console.error('Error:', error)
      }
    }
  }
  const editProductForm = document.getElementById('editProductForm')
  if (editProductForm) {
    editProductForm.onsubmit = async function (e) {
      e.preventDefault()

      const formData = new FormData(this)
      const productData = {
        category_id: parseInt(formData.get('category_id')),
        name: formData.get('name'),
        description: formData.get('description'),
        long_description: formData.get('long_description'),
        price: parseFloat(formData.get('price')),
        stock_quantity: parseInt(formData.get('stock_quantity')),
        image_url: formData.get('image_url') || null,
      }

      try {
        const response = await fetch(
          `http://localhost/pawsome/api/products/update_product.php?id=${formData.get(
            'product_id'
          )}`,
          {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
          }
        )

        const data = await response.json()

        if (!response.ok) {
          Swal.fire({
            title: 'Error!',
            text: data.error || 'Failed to update product',
            icon: 'error',
          })
          throw new Error(data.error || 'Failed to update product')
        }

        Swal.fire({
          title: 'Success!',
          text: 'Product updated successfully',
          icon: 'success',
          confirmButtonColor: '#3B82F6',
        }).then((result) => {
          if (result.isConfirmed || result.isDismissed) {
            window.location.href = './dashboard?tab=products'
          }
        })
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error.message || 'Failed to update product',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        console.error('Error:', error)
      }
    }
  }
})
