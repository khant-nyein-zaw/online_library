<template>
  <Header />

  <router-view />

  <Footer />
</template>

<script>
import Header from "@/components/HeaderComponent.vue";
import Footer from "@/components/FooterComponent.vue";
export default {
  name: "App",
  components: {
    Header,
    Footer,
  },
};
</script>
