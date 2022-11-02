<template>
  <div class="inventory">

    <v-btn style="margin-bottom: 10px" block
    @click="openPanel">
      Add Product
    </v-btn>
    <v-card
        class="mx-auto"
        max-width="500"
        tile
    >

      <v-card @click="showItem(product.id)" style="margin-bottom: 5px"
          v-for="product in products" v-bind:key="product.id"
      >

        <v-card-title>{{product.name}}</v-card-title>
        <v-card-subtitle>{{product.brand}}</v-card-subtitle>
        <v-card-text>Features: {{product.features}}</v-card-text>
        <v-card-text>Price: Rs. {{product.price}}</v-card-text>
        <v-card-text>Quantity: {{product.quantity}}</v-card-text>

      </v-card>


    </v-card>

    <v-dialog
        v-model="dialog"
        persistent
        max-width="600"
    >
      <template>
      </template>
      <v-card>
        <v-app-bar
            flat
            color="rgba(0, 0, 0, 0)"
        >
          <v-app-bar-nav-icon color="white"></v-app-bar-nav-icon>

          <v-spacer></v-spacer>

          <v-btn
              color="red"
              icon
              @click="deleteItem()"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-app-bar>
        <v-card-title class="text-h5">
         Product Details
        </v-card-title>
        <v-container>
          <v-row>
            <v-col
                cols="12"
                sm="6"
                md="4"
            >
              <v-text-field
                  label="Name"
                  v-model="name"
                  required
              ></v-text-field>
            </v-col>
            <v-col
                cols="12"
                sm="6"
                md="4"
            >
              <v-text-field
                  label="Brand"
                  hint="Brand"
                  v-model="brand"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                  label="Price"
                  hint="Price"
                  v-model="price"
                  persistent-hint
                  required
              ></v-text-field>
            </v-col>
            <v-col
                cols="12"
                sm="6"
                md="4"
            >
              <v-text-field
                  label="Quantity"
                  hint="Quantity"
                  v-model="quantity"
                  persistent-hint
                  required
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                  label="Features"
                  v-model="features"
                  required
              ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
              color="green darken-1"
              text
              @click="dialog = false"
          >
            close
          </v-btn>
          <v-btn
              v-if="action == 'view'"
              color="green darken-1"
              text
              @click="updateItem()"
          >
            Save
          </v-btn>
          <v-btn
              v-if="action == 'add'"
              color="green darken-1"
              text
              @click="addItem()"
          >
            Add to Inventory
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";

const user = JSON.parse(localStorage.getItem('user'));

export default {
  name: 'InventoryPage',

  components: {
  },

  data: () => ({
    action: null,
    products: [],
    productId: null,
    dialog: false,
    name: null,
    brand: null,
    price: null,
    features: null,
    quantity: null,

  }),

  methods: {
    getAllProducts(){
      console.log("user ", user)
      axios.get('http://127.0.0.1:8000/api/get_all_product/' + user.inventory.id).then(response => {
        this.products = response.data.product;
        console.log("products", this.products);
      })
    },

    showItem(id){
      this.action = "view";
        this.dialog = true;
        this.productId = id;
        axios.get('http://127.0.0.1:8000/api/get_product/'+id).then(response => {
          const product = response.data.product;
         this.name = product.name;
         this.brand = product.brand;
         this.price = product.price;
         this.features = product.features;
         this.quantity = product.quantity;
        });

    },

    updateItem(){
      const product = {
        name: this.name,
        brand: this.brand,
        price: this.price,
        features: this.features,
        quantity: this.quantity,
        inventory_id: user.inventory.id,
        availability: true
      }

      axios.put('http://127.0.0.1:8000/api/update_product/' + this.productId, product).then(response => {
        const product = response.data.product;
        this.name = product.name;
        this.brand = product.brand;
        this.price = product.price;
        this.features = product.features;
        this.quantity = product.quantity;

        alert("Product updated");
      });
    },
    deleteItem(){
      axios.delete('http://127.0.0.1:8000/api/delete_product/' + this.productId).then(response => {
        const id = response.data.data;
        if(id){
          alert("Item deleted");
          this.dialog = false;
          this.getAllProducts();
        }
      })
    },
    openPanel(){
      this.action = "add";
      this.name = null;
      this.brand = null;
      this.price =null;
      this.features = null;
      this.quantity = null;
      this.dialog = true;
    },

    addItem(){
      const product = {
        name: this.name,
        brand: this.brand,
        price: this.price,
        features: this.features,
        quantity: this.quantity,
        inventory_id: user.inventory.id,
        availability: true
      }

      axios.post('http://127.0.0.1:8000/api/add_product/', product).then(response => {
        const product = response.data.product;
        this.dialog = false;
        if(product.id){
          alert("Product Added");
          this.getAllProducts();
        }

      });
    },

  },
  mounted() {

    this.getAllProducts();
  }
}
</script>
