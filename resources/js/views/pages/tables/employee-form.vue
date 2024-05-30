<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
const route = useRoute()

const form = ref({
  username: '',
  email: '',
  password: '',
})

const getEmployeeById = async id => {
  try {
    const response = await axios.get(`/api/get-employee/${id}`)

    form.value.username = response.data.name
    form.value.email = response.data.email
    
    return response.data

  } catch (error) {
    alert(error.response.data.message)
  }
}
 
const addEmployee = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.post('/api/store-employee', {
      name: form.value.username,
      email: form.value.email,
      password: form.value.password,
      organization_id: user.organization_id,
    })

    alert('Successfully added new employee')
    form.value.username = ''
    form.value.email = ''
    form.value.password = ''

  } catch (error) {
    alert(error.response.data.message)
  }
} 
 
const onUpdateEmployee = async () => {
  try {
    const response = await axios.put(`/api/update-employee/${route.params.employeeId}`, {
      name: form.value.username,
      email: form.value.email,
    })

    alert('Successfully updated employee')
    form.value.username = ''
    form.value.email = ''
    getEmployeeById(route.params.employeeId)
  } catch (error) {
    alert(error.response.data.message)
  }
} 


if(route.params.employeeId) {
  getEmployeeById(route.params.employeeId)
}

const onCancelEmployee = () => {
  router.push('/employees-list')
}

const isPasswordVisible = ref(false)
</script>

<template>
  <VCard title="Employee Form">
    <VForm
      class="py-2 pb-9"
      @submit.prevent="addEmployee"
    >
      <VCol class="d-flex gap-2 btn-color justify-end">
        <VBtn
          class="button-color"
          variant="outlined"
          @click="onCancelEmployee"
        >
          Back
        </VBtn>
        <VBtn
          v-if="!route.params.employeeId"
          type="submit"
        >
          Confirm
        </VBtn>
        <VBtn
          v-if="route.params.employeeId"
          @click="onUpdateEmployee"
        >
          Update
        </VBtn>
      </VCol>
      <VCol
        cols="8"
        class="form-container"
      >
        <!-- Username -->
        <VCol
          cols="12"
          class="py-0"
        >
          <label for="username">User name</label>
        </VCol>
        <VCol cols="5 ">
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
        <VCol cols="5">
          <VTextField
            v-model="form.email"
            placeholder="Enter email"
            type="email"
          />
        </VCol>
              
        <!-- Password -->
        <VCol
          v-if="!route.params.employeeId"
          cols="12"
          class="py-0"
        >
          <label for="password">Password</label>
        </VCol>
        <VCol
          v-if="!route.params.employeeId"
          cols="5"
        >
          <VTextField
            v-model="form.password"
            placeholder="Enter Password"
            :type="isPasswordVisible ? 'text' : 'password'"
            :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
            @click:append-inner="isPasswordVisible = !isPasswordVisible"
          />
        </VCol>
      </VCol>
    </VForm>
  </VCard>
</template>

<style>
.btn-color {
  color: white;
}

.form-container {
  margin-inline-start: auto;
}
</style>
