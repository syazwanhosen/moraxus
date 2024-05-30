<script setup>
import axios from 'axios'
import { reactive } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

const option =  {
  chart: {
    height: 280,
    type: "radialBar",
  },
  colors: ['#87E05A'],
  plotOptions: {
    radialBar: {
      hollow: {
        size: "30%",
      },

      dataLabels: {
        showOn: "always",
        name: {
          show: false,
          color: "#888",
          fontSize: "8px",
        },
        value: {
          color: "#111",
          fontSize: "12px",
          show: true,
          offsetY: 4,
        },
      },
    },
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Progress"],
}

const sprints = reactive([])


const getSprints = async () => {
  const user = JSON.parse(localStorage.getItem('user'))
  try {
    const response = await axios.get(`/api/get-sprints/${user.organization_id}`)

    const newResponse = response.data.data.map(item => {
      return {
        ...item,
        moduleProgress: `${item.stage_completed}/${response.data.modules}`,
        percentage: (Number(item.stage_completed) / Number(response.data.modules)) * 100,
      }
    })

    sprints.splice(0, sprints.length, ...newResponse)

  } catch(error) {
    console.error(error)
  }
}

getSprints()
</script>

<template>
  <VCard title="Sprints">
    <VTable fixed-header>
      <thead>
        <tr>
          <th class="text-uppercase">
            Name
          </th>
          <th>
            Modules
          </th>
          <th>
            Progress
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="sprint in sprints"
          :key="sprint.id"
        >
          <td>
            {{ sprint.name }}
          </td>
          <td class="text-center">
            {{ sprint.moduleProgress }}
          </td>
          <td class="radialChart">
            <VueApexCharts
              type="radialBar"
              :options="option"
              :series="[sprint.percentage]"
              width="100"
              height="100"
            />
          </td>
        </tr>
      </tbody>
    </VTable>
  </VCard>
</template>

<style lang="scss" scoped>
  .card-list {
    --v-card-list-gap: 1.6rem;
  }

  .radialChart {
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
