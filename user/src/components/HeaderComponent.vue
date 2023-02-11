<template>
  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky" style="background-color: #7a6ad8">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <router-link to="/" class="logo">
              <h1>Online Library</h1>
            </router-link>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li class="scroll-to-section">
                <router-link :to="{ name: 'Home' }">Home</router-link>
              </li>
              <li class="scroll-to-section">
                <router-link :to="{ name: 'CategoryList' }">
                  Categories
                </router-link>
              </li>
              <li class="scroll-to-section">
                <router-link :to="{ name: 'UserBookList' }"
                  >My Book List</router-link
                >
              </li>
              <li class="scroll-to-section">
                <router-link :to="{ name: 'Login' }">Login</router-link>
              </li>
              <li class="scroll-to-section">
                <button class="btn btn-danger btn-sm" @click="logout">
                  Logout
                </button>
              </li>
            </ul>
            <a class="menu-trigger">
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
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
