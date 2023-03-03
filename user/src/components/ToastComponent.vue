<template>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast show fade" role="alert">
      <div class="toast-header">
        <strong class="me-auto">Notification</strong>
        <small></small>
        <button type="button" class="btn-close" @click="close"></button>
      </div>
      <div class="toast-body">
        <p class="text-muted fs-tiny">{{ message }}</p>
        <small v-if="reload">Reloading in {{ reloadTime }}</small>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ToastComponent",
  props: {
    message: String,
    reload: Boolean,
  },
  data() {
    return {
      reloadTime: 5,
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
  mounted() {
    if (this.reload) {
      setInterval(() => {
        this.reloadTime = this.reloadTime - 1;
      }, 1000);
    }
  },
};
</script>
