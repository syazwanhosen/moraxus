<script setup>
import illustrationJohnDark from '@images/cards/illustration-john-dark.png'
import illustrationJohnLight from '@images/cards/illustration-john-light.png'
import { useTheme } from 'vuetify'

const { global } = useTheme()
const user = JSON.parse(localStorage.getItem('user'))

const illustrationJohn = computed(() => global.name.value === 'dark' ? illustrationJohnDark : illustrationJohnLight)
</script>

<template>
  <VCard class="text-center text-sm-start">
    <VRow no-gutters>
      <VCol
        cols="12"
        order="2"
        order-sm="1"
      >
        <VCardItem>
          <VCardTitle class="text-md-h5 text-primary">
            Hi {{ user.name }}! 😊
          </VCardTitle>
        </VCardItem>

        <VCardText>
          <span>
            Your HR Dashboard is ready! 
          </span>
          <br>
          <span>
            Easily check the chart to track on employees training progress and completion status. Stay on top of professional development with just a glance.
          </span>
        </VCardText>
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss" scoped>
.john-illustration {
  inset-block-end: -0.0625rem;
  inset-inline-end: 3rem;
}
</style>
