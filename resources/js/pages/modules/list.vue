<script setup>
import axios from 'axios'
import { reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const modules = reactive([])

const toggleAddEmployeeForm = () => {
  router.push('/module-form')
}

const getModulesList = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.get(`/api/modules/${user.organization_id}`)

    modules.splice(0, modules.length, ...response.data)
  } catch(error) {
    console.error(error)
  }
}

getModulesList()

const onDeleteModule = async id => {
  try {
    const response = await axios.post(`/api/delete-module/${id}`)

    alert(response.data.message)
    window.location.reload()

  } catch(error) {
    console.error(error)
  }
}

const onEditModuule = id => {
  router.push(`/module-form/${id}`)
}
</script>

<template>
  <div>
    <VRow>
      <VCol cols="12">
        <!-- 👉 Horizontal Form -->
        <VCard title="Module">
          <VCol
            cols="2"
            class="button-container btn-color"
          >
            <VBtn
              block
              type="submit"
              class="button-color"
              @click="toggleAddEmployeeForm"
            >
              Add New Module
            </VBtn>
          </VCol>
          <VCol cols="12">
            <VTable fixed-header>
              <thead>
                <tr>
                  <th class="text-uppercase">
                    Module Name
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                    Uploaded File
                  </th>
                  <th>
                    Uploaded Video
                  </th>
                  <th>
                    Stage
                  </th>
                  <th>
                    Action
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="m in modules"
                  :key="m.id"
                >
                  <td>
                    {{ m.module_name }}
                  </td>
                  <td class="text-center">
                    {{ m.description }}
                  </td>
                  <td class="text-center">
                    {{ m.file_name || 'N/A' }} 
                  </td>
                  <td class="text-center">
                    {{ m.video_name || 'N/A' }} 
                  </td>
                  <td class="text-center">
                    {{ m.stage }} 
                  </td>
                  <td class="action-icon">
                    <VIcon
                      icon="bx-x"
                      color="#f61b3d"
                      class="icon"
                      @click="onDeleteModule(m.id)"
                    />
                    <VIcon
                      icon="bx-edit"
                      color="#1c1c1c"
                      class="icon"
                      @click="onEditModuule(m.id)"
                    />
                  </td>
                </tr>
              </tbody>
            </VTable>
          </VCol>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>

<style>
.btn-color {
  color: white;
  margin-inline-end: 0.5rem;
}

.form-container {
  margin-inline-start: auto;
}

.action-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}
</style>
