<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    user: {
        type: Object,
        required: false
    },
    me: {
        type: Object,
        required: true
    }
});
const user = props.user;
const emit = defineEmits(['dataSent']);
const token = localStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

const formData = ref({
    first_name: '',
    last_name: '',
    mobile: '',
    email: '',
    password: '',
    role: ''
});

const allowedRoles = ref([]);

const fetchAllowedRoles = async () => {
    try {
        const response = await axios.get('/api/v1/users/create');
        allowedRoles.value = response.data.roles;
    } catch (error) {
        console.error('Error fetching allowed roles:', error);
    }
};

const fetchUserData = async () => {
    if (props.user!=null) {
        try {
            const response = await axios.get(`/api/v1/users/${props.user.id}/edit`);
            formData.value = response.data.user;
            allowedRoles.value = response.data.roles;
        } catch (error) {
            console.error('Error fetching user data:', error);
        }
    }
};

const sendData = async () => {
    try {
        if (props.user!=null) {
            await axios.put(`/api/v1/users/${props.user.id}`, formData.value);
        } else {
            await axios.post('/api/v1/users', formData.value);
        }
        emit('dataSent', { user: props.me, action: 'index' });
    } catch (error) {
        console.error('Error sending data:', error);
    }
};
function sendDataToParent(user,action) {
    emit('dataSent', {
        user,
        action
    });
}
onMounted(() => {
    fetchAllowedRoles();
    fetchUserData();
});
</script>

<template>
    <div>
        <span>User Form</span>

        <br>
        <a href="#"  @click="sendDataToParent(null,'index')">Users list</a>
        <br>
        <form @submit.prevent="sendData">
            <div>
                <label for="first_name">First Name</label>
                <input id="first_name" v-model="formData.first_name" type="text" required>
            </div>
            <div>
                <label for="last_name">Last Name</label>
                <input id="last_name" v-model="formData.last_name" type="text" required>
            </div>
            <div>
                <label for="mobile">Mobile</label>
                <input id="mobile" v-model="formData.mobile" type="text" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" v-model="formData.email" type="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" v-model="formData.password" type="password" :required="props.user==null">
            </div>
            <div>
                <label for="role">Role</label>
                <select id="role" v-model="formData.role" required>
                    <option value="">Select a role</option>
                    <option v-for="role in allowedRoles" :key="role" :value="role">{{ role }}</option>
                </select>
            </div>
            <button type="submit">{{ user!==null ? 'Update User' : 'Create User' }}</button>
        </form>
    </div>
</template>
