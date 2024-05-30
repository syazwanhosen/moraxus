<script setup>
import axios from 'axios'
import dayjs from 'dayjs'
import { ref } from 'vue'
import VueApexCharts from 'vue3-apexcharts'
import {
  useDisplay,
  useTheme,
} from 'vuetify'

const vuetifyTheme = useTheme()
const display = useDisplay()

const recordsFilesDownloadedByMonth = ref(Array(12).fill(0))
const recordsVideoWatchedByMonth = ref(Array(12).fill(0))

const getFileDownloaded = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.get(`/api/file-download/${user.organization_id}`)

    countRecordsByMonth(response.data, recordsFilesDownloadedByMonth)

  } catch(error) {
    console.error(error)
  }
}

const getVideoWatched = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  try {
    const response = await axios.get(`/api/video-watch/${user.organization_id}`)

    countRecordsByMonth(response.data, recordsVideoWatchedByMonth)

  } catch(error) {
    console.error(error)
  }
}

getFileDownloaded()
getVideoWatched()

const countRecordsByMonth = (data, payload) => {
  const counts = Array(12).fill(0) // Initialize array with 12 zeros for each month

  data.forEach(item => {
    const month = dayjs(item.created_at).month() // Get month as a number (0-11)

    counts[month]++
  })

  payload.value = counts
}

const series = [
  {
    type: 'column',
    name: 'Files Downloaded',
    data: recordsFilesDownloadedByMonth,
  },
  {
    type: 'line',
    name: 'Videos Watched',
    data: recordsVideoWatchedByMonth,
  },
]

const chartOptions = {
  chart: {
    height: 350,
    type: 'line',
  },
  stroke: {
    width: [0, 4],
  },
  
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
 
}
</script>

<template>
  <VCard>
    <VRow no-gutters>
      <VCol
        cols="12"
        :class="$vuetify.display.smAndUp ? 'border-e' : 'border-b'"
      >
        <VCardItem class="pb-0">
          <VCardTitle>Total Interactions</VCardTitle>
        </VCardItem>
        <!-- bar chart -->
        <VueApexCharts
          :height="336"
          :options="chartOptions"
          :series="series"
        />
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss">
#bar-chart .apexcharts-series[rel="2"] {
  color: rgb(95, 158, 160);
  transform: translateY(-10px);
}
</style>
