<script setup>
import axios from 'axios'
import { reactive } from 'vue'

const feedbacks = reactive([])

const getFeedbackList = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.get(`/api/feedback/${user.organization_id}`)

    feedbacks.splice(0, feedbacks.length, ...response.data)
  } catch(error) {
    console.error(error)
  }
}

const formatDate = dateString => {
  const options = { day: 'numeric', month: 'long', year: 'numeric' }
  const date = new Date(dateString)
  
  return date.toLocaleDateString('en-US', options)
}

// Call the function to fetch feedbacks
getFeedbackList()
</script>

<template>
  <div>
    <VRow>
      <VCol cols="12">
        <!-- 👉 Horizontal Form -->
        <VCard title="List of Feedback">
          <VTable fixed-header>
            <thead>
              <tr>
                <th class="text-uppercase">
                  Name
                </th>
                <th>
                  Description
                </th>
                <th>
                  Created at
                </th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="feedback in feedbacks"
                :key="feedback.id"
              >
                <td>
                  {{ feedback.created_by }}
                </td>
                <td class="text-center">
                  {{ feedback.description }}
                </td>
                <td class="text-center">
                  {{ formatDate(feedback.created_at) }}
                </td>
              </tr>
            </tbody>
          </VTable>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>
