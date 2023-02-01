<template>
  <div class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner owl-loaded owl-drag">
            <div class="item item-1">
              <div class="header-text">
                <span class="category">Our Books</span>
                <h2>With online library, everything is easier.</h2>
                <p>
                  Search your books by author name, book title or ISBN numbers
                </p>
                <div class="buttons">
                  <!-- ***** Serach Start ***** -->
                  <div class="search-input">
                    <form id="search" @submit.prevent="search">
                      <input
                        type="text"
                        placeholder="Type Something"
                        id="searchText"
                        v-model="searchKey"
                        class="form-control"
                      />
                      <i class="fa fa-search"></i>
                    </form>
                  </div>
                  <!-- ***** Serach Start ***** -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="section courses" id="courses">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Latest Books</h6>
            <h2>Latest Books</h2>
          </div>
        </div>
      </div>
      <ul class="event_filter">
        <li>
          <a class="is_active" href="#">Show All</a>
        </li>
        <li v-for="category in categories" :key="category.id">
          <a href="#">{{ category.name }}</a>
        </li>
      </ul>
      <div class="row event_box">
        <div
          class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design"
          v-for="book in bookList"
          :key="book.id"
        >
          <div class="events_item">
            <div class="thumb">
              <a href="#"><img :src="book.image.filename" alt="" /></a>
              <span class="category">{{ book.category.name }}</span>
              <span class="price">
                <h6>{{ book.shelf.shelf_no }}</h6>
              </span>
            </div>
            <div class="down-content">
              <span class="author">{{ book.author }}</span>
              <h4>{{ book.title }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "HomePage",
  data() {
    return {
      categories: [],
      bookList: [],
      searchKey: "",
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    getBookList() {
      this.axios
        .get("/api/books", { headers: this.headers })
        .then((response) => {
          this.getImageUrl(response.data.books);
          this.bookList = response.data.books;
        })
        .catch((err) => console.log(err));
    },
    getImageUrl(books) {
      books.forEach((book) => {
        book.image.filename =
          "http://localhost:8000/storage/" + book.image.filename;
      });
    },
    getCategories() {
      this.axios
        .get("/api/categories", { headers: this.headers })
        .then((response) => {
          this.categories = response.data.categories;
        })
        .catch((err) => console.log(err));
    },
    search() {
      if (this.searchKey) {
        this.$router.push({
          name: "BookList",
          query: { searchKey: this.searchKey },
        });
      } else {
        alert("Please fill searchKey first");
      }
    },
  },
  mounted() {
    this.getCategories();
    this.getBookList();
  },
};
</script>
