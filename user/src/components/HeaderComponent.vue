<template>
  <!-- Sidebar -->
  <nav class="navbar-vertical navbar">
    <div class="nav-scroller">
      <!-- Brand logo -->
      <a class="navbar-brand" href="#">
        <img src="assets/images/brand/logo/logo.svg" alt="" />
      </a>
      <!-- Navbar nav -->
      <ul class="navbar-nav flex-column" id="sideNavbar">
        <li class="nav-item">
          <router-link :to="{ name: 'Home' }" class="nav-link has-arrow">
            <i class="fa-solid fa-house nav-icon icon-xs me-2"></i> Home
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            :to="{ name: 'CategoryList' }"
            class="nav-link has-arrow"
          >
            <i class="fa-solid fa-bars nav-icon icon-xs me-2"></i> Categories
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            :to="{ name: 'UserBookList' }"
            class="nav-link has-arrow"
          >
            <i class="fa-solid fa-book nav-icon icon-xs me-2"></i> My Books
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Login' }" class="nav-link has-arrow">
            <i class="fa-solid fa-unlock nav-icon icon-xs me-2"></i> Sign In
          </router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" @click="logout">
            <i class="fa-solid fa-lock nav-icon icon-xs me-2"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: "HeaderComponent",
  methods: {
    logout() {
      this.$store.dispatch("logout");
      this.$router.push({
        name: "Login",
      });
    },
  },
};
</script>
