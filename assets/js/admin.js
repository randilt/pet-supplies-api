// Fetch configuration
const apiUrl = '/api'
// Set up DOM event listeners
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

  // Add Product Form Handler
  const productForm = document.getElementById('productForm')
  if (productForm) {
    productForm.onsubmit = async function (e) {
      console.log('Product form submit handler triggered')

      e.preventDefault()

      if (!apiUrl) {
        Swal.fire({
          title: 'Error!',
          text: 'System is not properly configured. Please try again later.',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        return
      }

      const formData = new FormData(productForm)
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
        const response = await fetch(`${apiUrl}/v1/products.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(productData),
        })

        const data = await response.json()

        if (!response.ok) {
          throw new Error(
            data.error || data.errors?.join(', ') || 'Failed to add product'
          )
        }

        console.log(data)

        Swal.fire({
          title: 'Success!',
          text: 'Product added successfully',
          icon: 'success',
          confirmButtonColor: '#3B82F6',
        }).then((result) => {
          if (result.isConfirmed || result.isDismissed) {
            productForm.reset()
            location.reload()
          }
        })
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error.message || 'Failed to add product',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        console.error('Error:', error)
      }
    }
  }

  // Edit Product Form Handler
  const editProductForm = document.getElementById('editProductForm')
  if (editProductForm) {
    editProductForm.onsubmit = async function (e) {
      e.preventDefault()

      if (!apiUrl) {
        Swal.fire({
          title: 'Error!',
          text: 'System is not properly configured. Please try again later.',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        return
      }

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
          `${apiUrl}/v1/products.php?id=${formData.get('product_id')}`,
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

  // Add Category Form Handler
  const addCategoryForm = document.getElementById('addCategoryForm')
  if (addCategoryForm) {
    addCategoryForm.onsubmit = async function (e) {
      e.preventDefault()

      if (!apiUrl) {
        Swal.fire({
          title: 'Error!',
          text: 'System is not properly configured. Please try again later.',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        return
      }

      const data = {
        name: document.getElementById('category_name').value,
        description: document.getElementById('category_description').value,
      }

      try {
        const response = await fetch(`${apiUrl}/v1/categories.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        })

        const result = await response.json()

        if (result.categoryId) {
          Swal.fire({
            title: 'Success!',
            text: 'Category added successfully',
            icon: 'success',
            confirmButtonColor: '#3B82F6',
          }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
              addCategoryForm.reset()
              location.reload()
            }
          })
        } else {
          throw new Error(result.error || 'Failed to add category')
        }
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error.message || 'An error occurred',
          icon: 'error',
          confirmButtonColor: '#3B82F6',
        })
        console.error('Error:', error)
      }
    }
  }
})
