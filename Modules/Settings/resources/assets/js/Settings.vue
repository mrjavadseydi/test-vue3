<script setup>
import {onMounted, ref} from 'vue'
import axios from 'axios'

const settings = ref(null);
const selectedKey = ref('');
const selectedValue = ref('');
const message = ref('');
const token = localStorage.getItem('token')
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`


onMounted(async () => {
    settings.value = await getSettings()
})

const getSettings = async () => {
    try {
        const response = await axios.get('/api/v1/settings')
        return response.data// Adjust this path according to your response structure
    } catch (error) {
        console.error('getting settings failed :', error)
    }
}
const sendData = async () => {
    const payload = {
        option: selectedKey.value,
        action: selectedValue.value,
    };

    try {
        const token = localStorage.getItem('token');
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        const response = await axios.post('/api/v1/settings', payload);
        console.log('Data sent successfully:', response.data);

        message.value = response.data.message
    } catch (error) {
        message.value ="invalid data"

        console.error('Error sending data:', error);
    }
};

</script>

<template>
    <div>
        <!-- This will display the keys as paragraphs -->
        <center>
            <h1>
                Settings:
            </h1>
            <p v-if="message">
                {{ message }}
            </p>
        </center>

        <!-- This will display the settings object as a string for debugging -->

        <select v-model="selectedKey" @change="handleKeyChange">
            <option value="">Select a key</option>
            <!-- Iterate over the keys in the settings object for the select options -->
            <option v-for="(values, key) in settings" :key="key" :value="key">{{ key }}</option>
        </select>

        <div v-if="selectedKey">
            <select v-model="selectedValue">
                <option value="">Select a value</option>
                <!-- Iterate over the values for the selected key -->
                <option v-for="value in settings[selectedKey]" :key="value" :value="value">{{ value }}</option>
            </select>
            <button @click="sendData">Send</button>
        </div>
    </div>
</template>

