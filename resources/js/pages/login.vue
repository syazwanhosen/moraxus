
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


const loginForm = async () => {
  try {
    const response = await axios.post('/login', {
      username: form.value.loginUsername,
      password: form.value.loginPassword,
    })

    // If registration is successful, redirect to the home page
    if(response.data.redirect) {
      router.push(response.data.redirect)
      localStorage.setItem('user', JSON.stringify(response.data.user))
    }

    else alert('These credentials do not match our records.')
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
    <div class=" d-flex align-center justify-center ">
      <VCard
        class="auth-card"
        width="448"
      >
        <VCardItem class="justify-center">
          <VCardTitle class="text-2xl font-weight-bold text-center">
            Login
          </VCardTitle>
        </VCardItem>

        <VCardText>
          <VForm @submit.prevent="loginForm">
            <VRow>
              <!-- Username -->
              <VCol
                cols="12"
                class="py-0"
              >
                <label for="loginUsername">User name</label>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.loginUsername"
                  name="loginUsername"
                  autofocus
                  placeholder="Enter username"
                  type="loginUsername"
                />
              </VCol>

              <!-- Password -->
              <VCol
                cols="12"
                class="py-0"
              >
                <label for="loginPassword">Password</label>
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="form.loginPassword"
                  placeholder="Enter password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  name="loginPassword"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>

              <!-- Login Button -->
              <VCol cols="12">
                <VBtn
                  block
                  type="submit"
                  class="button-color"
                >
                  Login
                </VBtn>
              </VCol>
              <VCol cols="12">
                <VBtn
                  block
                  variant="outlined"
                  to="/register"
                >
                  Register as Company HR Representative
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";

.img-logo {
  margin: auto;
  inline-size: 20%;
}

.button-color {
  color: white;
}
</style>
