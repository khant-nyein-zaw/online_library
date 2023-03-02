<template>
  <div id="db-wrapper">
    <NavBar />
    <div id="page-content">
      <Header />
      <div class="container-fluid mt-3 px-3">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import Header from "@/components/HeaderComponent.vue";
import NavBar from "@/components/NavBarComponent.vue";
export default {
  name: "App",
  components: {
    NavBar,
    Header,
  },
};
</script>
