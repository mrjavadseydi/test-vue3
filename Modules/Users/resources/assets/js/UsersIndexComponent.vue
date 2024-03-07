<script setup>
import { ref, onMounted, defineEmits ,defineProps} from 'vue';
import axios from 'axios';

const users = ref([]);
const currentPage = ref(1);
const pageSize = ref(5); // Number of items per page
const totalItems = ref(0);
const totalPages = ref(0);
const props = defineProps({
    me: {
        type: Object,
        required: true
    }
});
// Define the custom event
const emit = defineEmits(['dataSent']);
function sendDataToParent(user,action) {
    emit('dataSent', {
        user,
        action
    });
    if (action === 'delete') {
        deleteUSer(user);
    }
}

onMounted(async () => {
    await getUsers();
});
const deleteUSer = async (user) => {
    try {
        const token = localStorage.getItem('token');
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        await axios.delete(`/api/v1/users/${user.id}`);
        await getUsers();
    } catch (error) {
        console.error('Deleting user failed:', error);
    }
};
const getUsers = async () => {
    try {
        const token = localStorage.getItem('token');
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        const response = await axios.get(`/api/v1/users?page=${currentPage.value}`);
        users.value = response.data.data;
        totalItems.value = response.data.meta.total;
        pageSize.value = response.data.meta.per_page;
        totalPages.value =  Math.ceil( totalItems.value / pageSize.value );

    } catch (error) {
        console.error('Getting users failed:', error);
    }
};
const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        getUsers();
    }
};
const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        getUsers();
    }
};
</script>

<template>
    <div>
        <a href="#" @click="sendDataToParent(null,'create')">Create User</a>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.first_name }}</td>
                    <td>{{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                    <td>
                        <button @click="sendDataToParent(user,'show')">Show</button>
                        <div v-if="!(me.role == 'operator' && user.role=='admin')">
                            <button  @click="sendDataToParent(user,'edit')">Edit</button>
                            <button @click="sendDataToParent(user,'delete')">Delete</button>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>


        <div>
            <button @click="prevPage" :disabled="currentPage <= 1">Previous</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage >= totalPages">Next</button>
        </div>
    </div>
</template>

<style scoped>
</style>
