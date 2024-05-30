<script setup>
import DemoSimpleTableFixedHeader from '@/views/pages/tables/DemoSimpleTableFixedHeader.vue'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const toggleAddEmployeeForm = () => {
  router.push('/employee-form')
}
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Employees">
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
            Add New Employee
          </VBtn>
        </VCol>
       
        <VCol cols="12">
          <DemoSimpleTableFixedHeader />
        </VCol>
      </VCard>
    </VCol>
  </VRow>
</template>

<style>
.btn-color {
  color: white;
  margin-inline-end: 0.5rem;
}

.form-container {
  margin-inline-start: auto;
}
</style>
