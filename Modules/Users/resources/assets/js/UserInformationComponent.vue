<script setup>
import {defineEmits, defineProps} from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    me: {
        type: Object,
        required: true
    }
});
const user = props.user;
const me = props.me;
const emit = defineEmits(['dataSent']);
function sendDataToParent(user,action) {
    emit('dataSent', {
        user,
        action
    });
}
</script>

<template>
    <div>
        <span>User information:</span>
        <br>
        <a href="#"  @click="sendDataToParent(null,'index')">Users list</a>
        <br>
        <span v-if="me.role == 'operator' && user.role=='admin'"> You are not allowed to edit this user</span>
        <a v-else href="#" @click="sendDataToParent(user,'edit')">Edit</a>
        <ul>
            <li>First Name: {{ user.first_name }}</li>
            <li>Last Name: {{ user.last_name }}</li>
            <li>Signup at : {{ user.created_at }}</li>
            <li>Last Update: {{ user.updated_at }}</li>
            <li>Email: {{ user.email }}</li>
            <li>Role: {{ user.role }}</li>
            <li>Phone: {{ user.mobile }}</li>
            <!-- Add more fields as needed based on the user object structure -->
        </ul>
    </div>
</template>

<style scoped>

</style>
