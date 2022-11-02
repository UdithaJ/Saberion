<template>
  <form>
    <v-text-field
        v-model="empId"
        :counter="10"
        label="Employee ID"
        required
    ></v-text-field>
    <v-text-field
        v-model="name"
        :counter="10"
        label="Name"
        required
    ></v-text-field>
    <v-select
        v-model="type"
        :items="types"
        item-text="name"
        item-value="id"
        label="User Type"
        persistent-hint
        return-object
        single-line
    ></v-select>
    <v-select
        v-model="branch"
        :items="branches"
        item-text="name"
        item-value="id"
        label="Branch"
        persistent-hint
        return-object
        single-line
    ></v-select>
    <v-text-field
        v-model="password"
        label="Password"
        type="password"
        required
    ></v-text-field>


    <v-btn
        class="mr-4"
        @click="register()"
    >
      Register
    </v-btn>
  </form>
</template>

<script>
import axios from "axios";
import router from "@/router";

export default {
  name: 'RegisterPage',

  components: {
  },

  data: () => ({
    empId: '',
    name: '',
    type: '',
    branch: '',
    password: '',
    branches: [],
    types: [
      {
        name: "HO",
        id: 1
      },
      {
        name: "Branch User",
        id: 2
      },
      {
        name: "Admin",
        id: 3
      }
    ]
  }),

  methods: {

    register(){
      console.log("branch ", this.branch)
      const credentials = {
        employee_id: this.empId,
        password: this.password,
        name: this.name,
        type: this.type.id,
        branch: this.branch.id
      };

      axios.post('http://127.0.0.1:8000/api/register', credentials).then(response => {
        console.log(response);
        router.push({name: 'home'});
      })
    },

    getAllBranches(){
      axios.get('http://127.0.0.1:8000/api/branches').then(response => {

        this.branches = response.data.branches;

      })
    }
  },

  mounted() {

    this.getAllBranches();
  }
}
</script>
