<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  image: {
    type: String,
    required: true,
  },
  stats: {
    type: String,
    required: true,
  },

})
</script>

<template>
  <VCard>
    <VCardText class="d-flex align-center pb-4">
      <img
        width="42"
        :src="props.image"
        alt="image"
      >
    </VCardText>

    <VCardText>
      <p class="mb-1">
        {{ props.title }}
      </p>
      <h5 class="text-h5 text-no-wrap mb-3">
        {{ props.stats }}
      </h5>
    </VCardText>
  </VCard>
</template>
