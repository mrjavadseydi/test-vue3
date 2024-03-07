<script setup>
import {onMounted, ref} from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const re_password = ref('')
const first_name = ref('')
const last_name = ref('')
const mobile = ref('')
const user = ref(null)
const loginError = ref(null)
const registerError = ref(null)

const checkToken = async () => {
    const token = localStorage.getItem('token')
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        try {
            const response = await axios.get('/api/user')
            user.value = response.data
        } catch (error) {
            console.error('Token validation error:', error)
            localStorage.removeItem('token')
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
        console.error('Login error:', error.response.data.message)
        loginError.value = error.response.data.message
    }
}
const signup = async () => {
    if (password.value !== re_password.value) {
        loginError.value = 'Passwords do not match'
        return
    }
    try {
        const response = await axios.post('/api/register', {
            email: email.value,
            password: password.value,
            password_confirmation: re_password.value,
            first_name: first_name.value,
            last_name: last_name.value,
            mobile: mobile.value
        })
        if (response.data.status === 'success') {
            const {token, user: userData} = response.data.data
            localStorage.setItem('token', token)
            user.value = userData
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            registerError.value = null
        } else {
            registerError.value = response.data.message || 'Register failed'
        }
    } catch (error) {
        console.error('register error:', error.response.data.message)
        registerError.value = error.response.data.message
    }
}
onMounted(checkToken)

</script>

<template>
    <div>



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
        <div v-else>
            <center>
                <h1>
                    Login
                </h1>
            </center>
            <div v-if="loginError">{{ loginError }}</div>

            <form @submit.prevent="login">
                <input type="email" v-model="email" placeholder="Email">
                <input type="password" v-model="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
            <hr>
            <center>
                <h1>
                    Register
                </h1>
            </center>
            <div v-if="registerError">{{ registerError }}</div>

            <form  @submit.prevent="signup">
                <input type="text" v-model="first_name" placeholder="First Name">
                <input type="text" v-model="last_name" placeholder="Last Name">
                <input type="text" v-model="mobile" placeholder="Mobile">
                <input type="email" v-model="email" placeholder="Email">
                <input type="password" v-model="password" placeholder="Password">
                <input type="password" v-model="re_password" placeholder="Re Password">
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</template>
