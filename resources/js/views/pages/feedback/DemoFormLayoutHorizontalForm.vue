<script setup>
import axios from 'axios'
import { ref } from 'vue'

const form = ref({
  description: '',
})

const feedbackForm = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.post('/api/store-feedback', {
      description: form.value.description,
      name: user.name,
      organization_id: user.organization_id,
    })

    alert('Successful added feedback.')
    form.value.description = ''
  } catch (error) {
    console.error('Registration failed:', error)

    // Handle registration failure, e.g., display error message to the user
  }
}
</script>

<template>
  <VForm @submit.prevent="feedbackForm">
    <VRow>
      <VCol cols="12">
        <VRow
          no-gutters
          class="align-center justify-center"
        >
          <VCol
            cols="12"
            md="6"
          >
            <VTextarea
              id="description"
              v-model="form.description"
              name="'description'"
              persistent-placeholder
              type="'text'"
            />
          </VCol>
        </VRow>
      </VCol>

     

      <!-- 👉 submit and reset button -->
      <VCol
        offset-md="3"
        cols="12"
      >
        <VBtn
          type="submit"
          class="button-color"
        >
          Submit
        </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>


<style>
.button-color {
  color: white;
}
</style>
