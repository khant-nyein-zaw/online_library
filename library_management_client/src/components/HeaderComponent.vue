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
            <!-- ***** Serach Start ***** -->
            <div class="search-input">
              <form id="search" action="#">
                <input
                  type="text"
                  placeholder="Type Something"
                  id="searchText"
                  name="searchKeyword"
                  @keyup.enter="search"
                />
                <i class="fa fa-search"></i>
              </form>
            </div>
            <!-- ***** Serach Start ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li class="scroll-to-section">
                <router-link :to="{ name: 'Home' }" class="active"
                  >Home</router-link
                >
              </li>
              <li class="scroll-to-section">
                <router-link :to="{ name: 'BookList' }"
                  >Book Library</router-link
                >
              </li>
              <li class="scroll-to-section">
                <router-link to="/">Register Now!</router-link>
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
