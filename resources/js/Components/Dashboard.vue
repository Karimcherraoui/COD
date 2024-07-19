<template>
    <div class="dashboard">
      <h1>Product Dashboard</h1>
      <button @click="showCreateForm = true">Create New Product</button>
      
      <!-- Product List -->
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>
              <img v-if="product.image" 
                   :src="getImageUrl(product.image)" 
                   :alt="product.name"
                   @error="handleImageError"
                   class="product-image">
              <span v-else>No image</span>
            </td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td>
              <button @click="editProduct(product)">Edit</button>
              <button @click="deleteProduct(product.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Create/Edit Form -->
      <div v-if="showCreateForm || editingProduct">
        <h2>{{ editingProduct ? 'Edit' : 'Create' }} Product</h2>
        <form @submit.prevent="saveProduct">
          <input v-model="form.name" placeholder="Name" required>
          <input v-model="form.description" placeholder="Description" required>
          <input v-model="form.price" type="number" step="0.01" placeholder="Price" required>
          <input type="file" @change="handleFileUpload">
          <img v-if="imagePreview" :src="imagePreview" alt="Image Preview" class="image-preview">
          <button type="submit">Save</button>
          <button @click="cancelForm">Cancel</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        products: [],
        showCreateForm: false,
        editingProduct: null,
        form: {
          name: '',
          description: '',
          price: '',
          image: null
        },
        imagePreview: null
      };
    },
  
    mounted() {
      this.fetchProducts();
    },
  
    methods: {
      async fetchProducts() {
        try {
          const response = await axios.get('/products');
          this.products = response.data;
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      },
  
      getImageUrl(image) {
        return `/storage/${image}`;
      },
  
      handleImageError(e) {
        e.target.src = '/images/fallback-image.jpg';
      },
  
      async saveProduct() {
  console.log('Form data before sending:', this.form);

  const formData = new FormData();
  for (const key in this.form) {
    console.log(`Appending ${key}:`, this.form[key]);
    if (this.form[key] instanceof File) {
      formData.append(key, this.form[key]);
    } else {
      formData.append(key, this.form[key]);
    }
  }

  try {
    if (this.editingProduct) {
      console.log('Updating product with ID:', this.editingProduct.id);
      const response = await axios.put(`/products/${this.editingProduct.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      console.log('Update response:', response.data);
    } else {
      console.log('Creating new product');
      const response = await axios.post('/products', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
      console.log('Create response:', response.data);
    }
    this.fetchProducts();
    this.cancelForm();
  } catch (error) {
    console.error('Error saving product:', error.response ? error.response.data : error.message);
  }
},
  
      cancelForm() {
        this.showCreateForm = false;
        this.editingProduct = null;
        this.form = {
          name: '',
          description: '',
          price: '',
          image: null
        };
        this.imagePreview = null;
      },
  
      handleFileUpload(event) {
        this.form.image = event.target.files[0];
        this.imagePreview = URL.createObjectURL(this.form.image);
      },
  
      editProduct(product) {
        this.editingProduct = product;
        this.showCreateForm = true;
        this.form.name = product.name;
        this.form.description = product.description;
        this.form.price = product.price;
        this.imagePreview = this.getImageUrl(product.image);
      }
    }
  }
  </script>
  
  <style scoped>
  .product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
  }
  
  .image-preview {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
  }
  </style>
  