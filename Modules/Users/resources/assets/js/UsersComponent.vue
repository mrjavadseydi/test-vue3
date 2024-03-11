<script setup>
import {ref} from 'vue'
import UserFormComponent from "./UserFormComponent.vue";
import UserInformationComponent from "./UserInformationComponent.vue";
import UserIndexComponent from "./UsersIndexComponent.vue";
import axios from 'axios'
/// let create a state to check if user on which page (create,show,edit,index)
const page = ref('index')
const users = ref([])
const currentUser = ref(null)
const me = ref(null)
const checkToken = async () => {
    const token = localStorage.getItem('token')
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        try {
            const response = await axios.get('/api/user')
            me.value = response.data // Adjust this path according to your response structure
        } catch (error) {
            console.error('Token validation error:', error)
            localStorage.removeItem('token') // Remove invalid token from localStorage
        }
    }
}
checkToken()

function handleDataFromChild(data) {
    const {user, action} = data
    if (action === 'show') {
        page.value = 'show'
        currentUser.value = user
    } else if (action === 'edit') {
        page.value = 'edit'
        currentUser.value = user
    } else if (action === 'create') {
        page.value = 'create'
    } else if (action === 'index') {
        page.value = 'index'
    } else if (action === 'delete') {
        page.value = 'index'
        //call the api to delete the user

    }
}


</script>

<template>
    <div>
        <h1>
            Users
        </h1>
        <router-link to="/">Home</router-link>
        <div v-if="page==='index'">
            <user-index-component :me="me" @data-sent="handleDataFromChild"/>
        </div>
        <div v-else-if="page==='create'">
            <user-form-component :user="null" :me="me" @data-sent="handleDataFromChild"/>
        </div>
        <div v-else-if="page==='edit'">
            <user-form-component :user="currentUser" :me="me" @data-sent="handleDataFromChild"/>
        </div>
        <div v-else-if="page==='show'">
            <user-information-component :user="currentUser" :me="me" @data-sent="handleDataFromChild"/>
        </div>
    </div>
</template>

<style scoped>

</style>
