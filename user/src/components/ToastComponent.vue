<template>
  <div
    class="toast-container position-fixed bottom-0 end-0 p-3"
    v-if="!isClosed"
  >
    <div id="liveToast" class="toast show fade" role="alert">
      <div class="toast-header">
        <strong class="me-auto">Notification</strong>
        <small></small>
        <button type="button" class="btn-close" @click="closeToast"></button>
      </div>
      <div class="toast-body">
        <small>{{ message }}</small>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ToastComponent",
  props: {
    message: String,
  },
  data() {
    return {
      isClosed: false,
    };
  },
  methods: {
    closeToast() {
      this.isClosed = true;
    },
  },
};
</script>
