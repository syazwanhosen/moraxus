<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
const route = useRoute()

// Define reactive properties
const form = ref({
  moduleName: '',
  description: '',
  stage: '',
  file: null,
  video: null,
})

const fileName = ref('')
const videoName = ref('')



// Update module function
const onUpdateModule = async () => {

  const formData = new FormData()

  if (form?.value?.file && form?.value?.file[0]) { // Check if file exists
    formData.append('file', form.value.file[0])
  } 

  if (form?.value?.video && form?.value?.video[0]) { // Check if video exists
    formData.append('video', form.value.video[0])
  }

  formData.append('moduleName', form.value.moduleName)
  formData.append('description', form.value.description)
  formData.append('stage', form.value.stage)
  formData.append('id', route.params.moduleId)
  
  try {
    const response = await axios.post(`/api/update-module`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    alert('Successfully updated module')
    resetForm()
    getModuleById(route.params.moduleId)

  } catch (error) {
    alert(error.response.data.message)
  }
}

// Add module function
const addModule = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  const formData = new FormData()

  if (form.value.file) { // Check if file exists
    formData.append('file', form.value.file[0])
  }
  if (form.value.video) { // Check if video exists
    formData.append('video', form.value.video[0])
  }

  formData.append('moduleName', form.value.moduleName)
  formData.append('description', form.value.description)
  formData.append('stage', form.value.stage)
  formData.append('organization_id', user.organization_id)

  try {
    const response = await axios.post('/api/store-module', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    alert('Successfully added new module')
    resetForm()

  } catch (error) {
    console.log(error, 'error')
    alert(error.response.data.message)
  }
} 

// Get module by ID function
const getModuleById = async id => {
  try {
    const response = await axios.get(`/api/get-module/${id}`)

    form.value.moduleName = response.data.module_name
    form.value.description = response.data.description
    form.value.stage = response.data.stage
    if (response.data.file_name) {
      fileName.value = response.data.file_name
    }
    
    if (response.data.video_name) {
      videoName.value = response.data.video_name
    }
    
    
    return response.data

  } catch (error) {
    alert(error.response.data.message)
  }
}

 

if(route.params.moduleId) {
  getModuleById(route.params.moduleId)
}

// Reset form function
const resetForm = () => {
  form.value.moduleName = ''
  form.value.description = ''
  form.value.stage = ''
  form.value.file = null
  form.value.video = null
}

// Cancel module function
const onCancelModule = () => {
  router.push('/modules-list')
}

// Check if password is visible
const isPasswordVisible = ref(false)
</script>

<template>
  <VCard title="Module Form">
    <VForm
      class="py-2 pb-9"
      @submit.prevent="addModule"
    >
      <VCol class="d-flex gap-2 btn-color justify-end">
        <VBtn
          class="button-color"
          variant="outlined"
          @click="onCancelModule"
        >
          Back
        </VBtn>
        <VBtn
          v-if="!route.params.moduleId"
          type="submit"
        >
          Confirm
        </VBtn>
        <VBtn
          v-if="route.params.moduleId"
          @click="onUpdateModule"
        >
          Update
        </VBtn>
      </VCol>
      <VCol
        cols="8"
        class="form-container"
      >
        <VCol
          cols="12"
          class="py-0"
        >
          <label for="moduleName">Module Name</label>
        </VCol>
        <VCol cols="5 ">
          <VTextField
            v-model="form.moduleName"
            autofocus
            placeholder="Enter module name"
          />
        </VCol>

        <VCol
          cols="12"
          class="py-0"
        >
          <label for="description">Description</label>
        </VCol>
        <VCol cols="5">
          <VTextField
            v-model="form.description"
            placeholder="Enter description"
          />
        </VCol>
              

        <VCol
          cols="12"
          class="py-0"
        >
          <label for="stage">Stage</label>
        </VCol>
        <VCol cols="5">
          <VTextField
            v-model="form.stage"
            placeholder="Enter stage"
          />
        </VCol>
              
        <VCol
          v-if="!route.params.file"
          cols="12"
          class="py-0"
        >
          <label for="file">Upload Document</label>
        </VCol>
        <VCol
          v-if="!route.params.file"
          cols="5"
        >
          <VFileInput
            v-model="form.file"
            accept=".pdf, .doc, .docx, image/*"
            show-size
            :label="!form.file ? fileName : 'Upload file'"
            placeholder="Select file"
          />
        </VCol>

        <VCol
          v-if="!route.params.video"
          cols="12"
          class="py-0"
        >
          <label for="video">Upload Video</label>
        </VCol> 
        <VCol
          v-if="!route.params.video"
          cols="5"
        >
          <VFileInput
            v-model="form.video"
            accept=".mp4, .mov, .ogg, .qt, video/mp4, video/quicktime, video/ogg"
            truncate-length="15"
            :label="!form.video ? videoName : 'Upload video'"
            placeholder="Select video"
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
