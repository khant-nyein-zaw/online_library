<template>
  <div id="db-wrapper">
    <Header />
    <div id="page-content">
      <div class="header">
        <!-- navbar -->
        <nav class="navbar-classic navbar navbar-expand-lg">
          <a id="nav-toggle" href="#"
            ><i class="fa-solid fa-bars nav-icon me-2 icon-xs"></i
          ></a>
          <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <form class="d-flex align-items-center">
              <input type="search" class="form-control" placeholder="Search" />
            </form>
          </div>
        </nav>
      </div>
      <div class="container-fluid mt-3 px-3">
        <router-view />
      </div>
    </div>
  </div>

  <!-- <router-view /> -->
</template>

<script>
import Header from "@/components/HeaderComponent.vue";
export default {
  name: "App",
  components: {
    Header,
  },
};
</script>
