<template>
  <div id="db-wrapper">
    <NavBar />
    <div id="page-content">
      <div class="container-fluid mt-3 px-3">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "@/components/NavBarComponent.vue";
export default {
  name: "App",
  components: {
    NavBar,
  },
};
</script>
