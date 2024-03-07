<script setup>
import {onMounted, ref} from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const user = ref(null)
const loginError = ref(null)

const checkToken = async () => {
    const token = localStorage.getItem('token')
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        try {
            const response = await axios.get('/api/user')
            user.value = response.data // Adjust this path according to your response structure
        } catch (error) {
            console.error('Token validation error:', error)
            localStorage.removeItem('token') // Remove invalid token from localStorage
        }
    }
}
const logout = () => {
    localStorage.removeItem('token')
    axios.defaults.headers.common['Authorization'] = null
    axios.post('/api/logout')
    user.value = null
}
const login = async () => {
    try {
        const response = await axios.post('/api/login', {
            email: email.value,
            password: password.value
        })

        // Check if the login was successful
        if (response.data.status === 'success') {
            const {token, user: userData} = response.data.data

            // Save the token for future requests
            localStorage.setItem('token', token)
            user.value = userData

            // Set the authorization header for future axios requests
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

            loginError.value = null
        } else {
            loginError.value = response.data.message || 'Login failed'
        }
    } catch (error) {
        console.error('Login error:', error)
        loginError.value = 'An error occurred during login'
    }
}
onMounted(checkToken)

</script>

<template>
    <div>


        <div v-if="loginError">{{ loginError }}</div>

        <div v-if="user">
            <div v-if="user.role=='customer'">
            <span>
                Sorry, you are not authorized to do anything here
            </span>
            </div>
            <div v-if="user.role === 'admin' || user.role === 'operator'">
                <a href="/users">Users Page</a>
            </div>
            <div v-if="user.role === 'admin'">
                <hr>
                <a href="/settings">Settings</a>
            </div>
            <hr>
            <a href="#" @click="logout">Exit</a>
        </div>
        <form v-else @submit.prevent="login">
            <input type="email" v-model="email" placeholder="Email">
            <input type="password" v-model="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
</template>
