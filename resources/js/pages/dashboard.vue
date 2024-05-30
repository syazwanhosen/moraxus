<script setup>
import AnalyticsCongratulations from '@/views/dashboard/AnalyticsCongratulations.vue'
import AnalyticsTotalFileDownloaded from '@/views/dashboard/AnalyticsTotalFileDownloaded.vue'
import AnalyticsTransactions from '@/views/dashboard/AnalyticsTransactions.vue'
import axios from 'axios'
import { ref } from 'vue'

// 👉 Images
import documents from '@images/documents.png'
import employees from '@images/employees.png'
import feedbacks from '@images/feedbacks.png'
import videos from '@images/videos.png'


const usersCount = ref('')
const documentsCount = ref('')
const videoCount = ref('')
const feedbacksCount = ref('')

const getDashboard = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.get(`/api/get-dashboard/${user.organization_id}`)

    usersCount.value = response.data.users_count
    documentsCount.value = response.data.documents_count
    videoCount.value = response.data.videos_count
    feedbacksCount.value = response.data.feedbacks_count
  } catch(error) {
    console.error(error)
  }
}

getDashboard()
</script>

<template>
  <VRow>
    <!-- 👉 Congratulations -->
    <VCol
      cols="12"
      md="8"
    >
      <AnalyticsCongratulations />
    </VCol>

    <VCol
      cols="12"
      sm="4"
    >
      <VRow>
        <!-- 👉 Profit -->
        <VCol
          cols="12"
          md="6"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Documents',
              image: documents,
              stats: documentsCount,
            }"
          />
        </VCol>

        <!-- 👉 Sales -->
        <VCol
          cols="12"
          md="6"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Videos',
              image: videos,
              stats: videoCount,
            }"
          />
        </VCol>
      </VRow>
    </VCol>

    <!-- 👉 Total Revenue -->
    <VCol
      cols="12"
      md="8"
    >
      <AnalyticsTotalFileDownloaded />
    </VCol>
  
   

    <VCol
      cols="12"
      sm="8"
      md="4"
    >
      <VRow>
        <!-- 👉 Payments -->
        <VCol
          cols="12"
          sm="6"
        >
          <CardStatisticsVertical
            v-bind=" {
              title: 'Employees',
              image: employees,
              stats: usersCount,
            }"
          />
        </VCol>

        <!-- 👉 Revenue -->
        <VCol
          cols="12"
          sm="6"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Feedbacks',
              image: feedbacks,
              stats: feedbacksCount,
            }"
          />
        </VCol>
      </VRow>
      <VRow>
        <VCol cols="12">
          <AnalyticsTransactions />
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>
