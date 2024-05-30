<script setup>
import axios from 'axios'
import { ref } from 'vue'

const form = ref({
  video: '',
})

const moduleForm = async () => {
  console.log("testest")
  try {

    const response = await axios.post('/module', {
      video: form.value.video,
    },
    {
      headers: {
        'Content-Type': 'multipart/form-data', 
      },
    },
    )

    console.log(response, 'response')
  } catch (error) {
    console.error('Registration failed:', error)

    // Handle registration failure, e.g., display error message to the user
  }
}
</script>

<template>
  <div class="drag-area">
    <VForm @submit.prevent="moduleForm">
      <CsrfTokenInput />
      <VTextField
        v-model="form.video"
        type="file"
        name="video"
      />
      <VBtn
        type="submit"
        name="click"
      >
        Submit
      </VBtn>
    </VForm>
  </div>
</template>

