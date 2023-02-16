<template>
  <div id="db-wrapper">
    <NavBar />
    <div id="page-content">
      <div class="header">
        <!-- navbar -->
        <nav class="navbar-classic navbar navbar-expand-lg">
          <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <form class="d-flex align-items-center" @submit.prevent="search">
              <input
                type="search"
                class="form-control"
                placeholder="Search Books"
                v-model="searchKey"
              />
            </form>
          </div>
        </nav>
      </div>
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
  data() {
    return {
      searchKey: "",
    };
  },
  methods: {
    search() {
      this.$router.push({
        name: "BookList",
        query: { searchKey: this.searchKey },
      });
    },
  },
};
</script>
