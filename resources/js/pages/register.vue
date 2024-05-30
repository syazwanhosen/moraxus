<script setup>
import logo from '@images/logo/Logo.png'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const form = ref({
  loginUsername: '',
  email: '',
  loginPassword: '',
})

const isPasswordVisible = ref(false)

const router = useRouter()

const submitForm = async () => {
  try {
    const response = await axios.post('/register', {
      name: form.value.username,
      email: form.value.email,
      password: form.value.password,
    })

    // If registration is successful, redirect to the home page
    router.push('/dashboard/admin')
  } catch (error) {
    console.error('Registration failed:', error)
    alert(error.response.data.message)

    // Handle registration failure, e.g., display error message to the user
  }
}
</script>

<template>
  <div class="my-10">
    <div class=" img-logo my-5">
      <VImg
        :src="logo"
        alt="'img'"
      />
    </div>
    <div class="d-flex align-center justify-center">
      <VCard
        class="auth-card "
        width="448"
        height="500"
      >
        <VCardItem class="justify-center">
          <VCardTitle class="text-2xl font-weight-bold">
            Registration
          </VCardTitle>
        </VCardItem>

        <VCardText class="m-10">
          <VForm @submit.prevent="submitForm">
            <VRow>
              <!-- Username -->
              <VCol
                cols="12"
                class="py-0"
              >
                <label for="username">User name</label>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.username"
                  autofocus
                  placeholder="Enter username"
                />
              </VCol>
              <!-- email -->
              <VCol
                cols="12"
                class="py-0"
              >
                <label for="email">Email</label>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.email"
                  placeholder="Enter email"
                  type="email"
                />
              </VCol>

              <!-- password -->
              <VCol
                cols="12"
                class="py-0"
              >
                <label for="password">Password</label>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.password"
                  placeholder="Enter Password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>

              <!-- Submit Button -->
              <VCol cols="12">
                <VBtn
                  block
                  type="submit"
                  class="button-color"
                >
                  Register
                </VBtn>
              </VCol>
              <VCol cols="12">
                <VBtn
                  block
                  to="/login"
                  variant="outlined"
                  class="button-color"
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>

<style>
.register-container {
  margin: auto;
}
</style>
