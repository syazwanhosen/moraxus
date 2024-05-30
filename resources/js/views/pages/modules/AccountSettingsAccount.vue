<script>
export default {
  data() {
    return {
      videoSource: 'path_to_your_video.mp4',
    }
  },
  methods: {
    playVideo() {
      this.$refs.videoPlayer.play()
    },
    pauseVideo() {
      this.$refs.videoPlayer.pause()
    },
    stopVideo() {
      this.$refs.videoPlayer.pause()
      this.$refs.videoPlayer.currentTime = 0
    },
  },
}
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Chapter 1: Introduction">
        <VCardText class="d-flex ">
          <VRow class="align-center justify-center mx-auto my-auto">
            <VCol
              cols="12"
              md="6"
            >
              <video
                width="600"
                height="400"
                controls
              >
                <source
                  src="movie.mp4"
                  type="video/mp4"
                >
              </video>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
