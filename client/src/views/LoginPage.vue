<template>
    <form>
      <v-text-field
          v-model="empId"
          :counter="10"
          label="Employee ID"
          required
      ></v-text-field>
      <v-text-field
          v-model="password"
          label="Password"
          type="password"
          required
      ></v-text-field>


      <v-btn
          class="mr-4"
          @click="login"
      >
        submit
      </v-btn>

      <v-btn
          class="mr-4"
          @click="toSignUp"
      >
        Sign Up
      </v-btn>
    </form>
</template>

<script>
import axios from "axios";
import router from "@/router";

  export default {
    name: 'LoginPage',

    components: {
    },

    data: () => ({
      empId: '',
      password: ''
    }),

    methods: {
      login(){
        const credentials = {
          employee_id: this.empId,
          password: this.password
        };

        localStorage.setItem('user', null)

        axios.post('http://127.0.0.1:8000/api/login', credentials).then(response => {
          console.log(response);
          localStorage.setItem('user', JSON.stringify(response.data.user))
          router.push({name: 'inventory'});
        })
      },
      toSignUp(){
        router.push({name: 'register'});
      }
    }
  }
</script>
