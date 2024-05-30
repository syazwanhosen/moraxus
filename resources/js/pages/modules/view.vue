<script setup>
import axios from 'axios'
import { ref } from 'vue'

import { useRoute, useRouter } from 'vue-router'

// Define reactive properties
const form = ref({
  moduleName: '',
  description: '',
  file: null,
})

const route = useRoute()
const router = useRouter()

const fileName = ref('')
const filePath = ref('')
const videoName = ref('')
const videoPath = ref('')
const totalModules = ref(null)


// eslint-disable-next-line sonarjs/cognitive-complexity
const handleNext = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  if (Number(route.params.stage) === totalModules.value) {
    handleComplete()
  } else {

    try {
      const response = await axios.get(`/api/get-sprints/${user.organization_id}`)

      totalModules.value = response.data.modules

    } catch(error) {
      console.error(error)
    }


    try {
      const response = await axios.post('/api/store-video-watch', {
        organization_id: user.organization_id,
        user_id: user.id,
        stage: route.params.stage,
      })
    } catch (error) {
      alert(error.response.data.message)
    }

    if(Number(route.params.stage) < totalModules.value) {
      try {
        const stageCount = Number(route.params.stage) + 1
        const response = await axios.get(`/api/get-module-by-stage/${user.organization_id}/${stageCount}`)

        if (response.data.video_path) {
          const [_, vidPath] = response.data.video_path.split('/')

          videoName.value = response.data.video_name
          videoPath.value = vidPath
        }
        if (!response.data.video_path) {
          videoName.value = ''
          videoPath.value = ''
        }
        if (response.data.file_path) {
          const [_, failPath] = response.data.file_path.split('/')

          fileName.value = response.data.file_name
          filePath.value = failPath
        }
        if (!response.data.file_path) {
          fileName.value = ''
          filePath.value = ''
        }
        form.value.moduleName = response.data.module_name
        form.value.description = response.data.description
        router.push(`/modules-view/${stageCount}`)
    
      } catch (error) {
        alert(error.response.data.message)
      }
    }
  }
}

const handleComplete = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.post('/api/store-video-watch', {
      organization_id: user.organization_id,
      user_id: user.id,
      stage: route.params.stage,
    })
  } catch (error) {
    alert(error.response.data.message)
  }

  alert('Congratulation! You have completed the training.')
}


// Get module by ID function
const getModuleById = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.get(`/api/get-module-by-organization-id/${user.organization_id}`)
    if (response.data.video_path) {
      const [_, vidPath] = response.data.video_path.split('/')

      videoName.value = response.data.video_name
      videoPath.value = vidPath
    }
    if (response.data.file_path) {
      const [_, failPath] = response.data.file_path.split('/')

      fileName.value = response.data.file_name
      filePath.value = failPath
    }

    form.value.moduleName = response.data.module_name
    form.value.description = response.data.description
    
    return response.data

  } catch (error) {
    alert(error.response.data.message)
  }
}

const downloadFile = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.get(`/api/download/${filePath.value}`, {
      responseType: 'blob', // Important for binary data
      headers: {
        'Content-Type': 'application/pdf',
      },
    })

    // Create a new Blob object using the response data of the file
    const blob = new Blob([response.data], { type: response.headers['content-type'] })

    // Create a link element, use it to trigger the download, and then remove it
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.setAttribute('download', filePath.value)
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

    // Clean up
    window.URL.revokeObjectURL(url)
  } catch (error) {
    console.error('Error downloading file:', error)
    alert('An error occurred while downloading the file.')
  }

  try {
    const response = await axios.post('/api/store-file-download', {
      organization_id: user.organization_id,
    })
  } catch (error) {
    alert(error.response.data.message)
  }
}

if (route.params.stage == 1)getModuleById()
</script>

<template>
  <VCard title="Module for employee">
    <div class="module-view-container">
      <div class="label">
        {{ form.moduleName }}
      </div>     
      <div class="description">
        {{ form.description }}
      </div> 
      <div v-if="filePath">
        <a
          class="download"
          @click="downloadFile"
        >
          {{ fileName }}
        </a>
      </div>  
      <div
        v-if="videoPath"
        class="video"
      >
        <video
          width="620"
          height="420"
          :src="'/storage/' + videoPath"
          controls
        />
      </div>
      <VCol
        cols="12"
        class="button-container"
      >
        <VBtn @click="handleNext">
          {{ Number(route.params.stage) === totalModules ? 'Complete' : 'Next' }}
        </VBtn>
      </VCol>
    </div>  
  </VCard>
</template>

<style lang="scss">
.label {
  font-size: 2rem;
  font-weight: bold;
}

.description {
  margin-block-end: 2rem;
}

.download {
  cursor: pointer;
}

.module-view-container {
  padding: 2rem;
}

.video {
  display: flex;
  align-items: center;
  justify-content: center;
}

.button-container {
  color: white;
  text-align: end;
}
</style>
