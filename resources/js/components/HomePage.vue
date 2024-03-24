<template>
  <v-main>
    <v-content>
      <div class="main">
        <div class="content">
          <v-card class="login-card" v-if="loginMode">
            <v-card-title class="title">Login</v-card-title>
            <v-card-text>
              <v-text-field v-model="username" label="Username"></v-text-field>
              <v-text-field v-model="password" label="Password" type="password"></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="handleLogin">Login</v-btn>
              <v-btn color="primary" @click="toggleMode">Sign Up</v-btn>
            </v-card-actions>
          </v-card>

          <v-card class="signup-card" v-else>
            <v-card-title class="title">Sign Up</v-card-title>
            <v-card-text>
              <v-text-field v-model="name" label="Name"></v-text-field>
              <v-text-field v-model="email" label="Email"></v-text-field>
              <v-text-field v-model="username" label="Username"></v-text-field>
              <v-text-field v-model="password" label="Password" type="password"></v-text-field>
              <v-text-field v-model="confirmPassword" label="Confirm Password" type="password"></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="handleSignUp">Sign Up</v-btn>
              <v-btn color="primary" @click="toggleMode">Login</v-btn>
            </v-card-actions>
          </v-card>
        </div>
      </div>
    </v-content>
  </v-main>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router' 

const loginMode = ref(true)
const name = ref('') //var for name
const email = ref('') //var for email
const username = ref('') //var for username
const password = ref('') //var for password
const confirmPassword = ref('') //var for confirm password
const router = useRouter()  //var for router



//login logic
const handleLogin = async () => {
  try {
    const response = await axios.post('/api/login', {
      username: username.value,
      password: password.value
    })
    console.log('Login successful:', response.data)
    
    alert('Login successful') // navigate to main page

    router.push('/mainpage') //navigate to mainpage
  
  } catch (error) {
    console.error('Login failed:', error.response.data)
    alert('Invalid Username or Password!')
    username.value = ''
    password.value = ''

  }
}

//sign up logic

const handleSignUp = async () => {
  try {
    if (password.value !== confirmPassword.value) {
      throw new Error("Passwords don't match")
     
    }
    const response = await axios.post('/api/register', {
      name: name.value,
      email: email.value,
      username: username.value,
      password: password.value
    })
    console.log('Sign up successful:', response.data)
    alert('Sign up successful')
    router.push('/mainpage')
    // Reset fields after successful signup
    name.value = ''
    email.value = ''
    username.value = ''
    password.value = ''
    confirmPassword.value = ''
  } catch (error) {
    console.error('Sign up failed:', error.message)
    alert('Sign up failed: ' + error.message)
  }
}

const toggleMode = () => {
  loginMode.value = !loginMode.value
}
</script>

<!---Styling -->
<style scoped>
.main {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.content {
  width: 300px;
}

.title {
  text-align: center;
}

.login-card, .signup-card {
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
