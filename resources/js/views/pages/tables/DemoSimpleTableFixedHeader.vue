<script setup>
import axios from 'axios'
import { reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const employees = reactive([])

const getEmployeesList = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.get(`/api/employees/${user.organization_id}`)

    employees.splice(0, employees.length, ...response.data)
  } catch(error) {
    console.error(error)
  }
}

const formatDate = dateString => {
  const options = { day: 'numeric', month: 'long', year: 'numeric' }
  const date = new Date(dateString)
  
  return date.toLocaleDateString('en-US', options)
}

const onDeleteEmployee = async id => {
  try {
    const response = await axios.post(`/api/delete-employee/${id}`)

    alert(response.data.message)
    window.location.reload()

  } catch(error) {
    console.error(error)
  }
}

const onEditEmployee = id => {
  router.push(`/employee-form/${id}`)
}

getEmployeesList()
</script>

<template>
  <VTable fixed-header>
    <thead>
      <tr>
        <th class="text-uppercase">
          Name
        </th>
        <th>
          Email
        </th>
        <th>
          Created at
        </th>
        <th>
          Action
        </th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="employee in employees"
        :key="employee.id"
      >
        <td>
          {{ employee.name }}
        </td>
        <td class="text-center">
          {{ employee.email }}
        </td>
        <td class="text-center">
          {{ formatDate(employee.created_at) }}
        </td>
        <td class="action-icon">
          <VIcon
            icon="bx-x"
            color="#f61b3d"
            class="icon"
            @click="onDeleteEmployee(employee.id)"
          />
          <VIcon
            icon="bx-edit"
            color="#1c1c1c"
            class="icon"
            @click="onEditEmployee(employee.id)"
          />
        </td>
      </tr>
    </tbody>
  </VTable>
</template>

<style>
.button-container {
  margin-inline-start: auto;
}

.add-employee-button {
  color: white;
}

.action-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.icon {
  &:hover {
    cursor: pointer;
  }
}
</style>
