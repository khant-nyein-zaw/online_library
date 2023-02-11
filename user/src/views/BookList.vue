<template>
  <div class="section events" id="events">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Books</h6>
            <h2>Most popular books in library</h2>
          </div>
          <div class="col-3 offset-9 mb-5">
            <select class="form-control" v-model="sortBy" @change="sort">
              <option value="">Sort By</option>
              <option value="asc">Earliest</option>
              <option value="desc">Latest</option>
            </select>
          </div>
        </div>
        <div class="col-lg-12 col-md-6" v-for="book in bookList" :key="book.id">
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
                <div class="image">
                  <img :src="book.image.filename" alt="" />
                </div>
              </div>
              <div class="col-lg-9">
                <ul>
                  <li>
                    <span class="category">{{ book.category.name }}</span>
                    <h4>{{ book.title }}</h4>
                  </li>
                  <li>
                    <span>Author</span>
                    <h6>{{ book.author }}</h6>
                  </li>
                  <li>
                    <span>Publisher</span>
                    <h6>{{ book.publisher }}</h6>
                  </li>
                  <li>
                    <span>Shelf</span>
                    <h6>{{ book.shelf.shelf_no }}</h6>
                  </li>
                </ul>
                <a href="#" @click="showDetails(book.id)"
                  ><i class="fa fa-angle-right"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "BookList",
  data() {
    return {
      bookList: [],
      sortBy: "",
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    sort() {
      if (this.sortBy) {
        this.axios
          .get(`/api/books/${this.sortBy}/all`, { headers: this.headers })
          .then((response) => {
            this.getImageUrl(response.data.books);
            this.bookList = response.data.books;
          })
          .catch((err) => console.log(err));
      }
    },
    getBooksWithSearch() {
      this.axios
        .post(
          "/api/books/search",
          {
            query: this.$route.query.searchKey,
          },
          { headers: this.headers }
        )
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
    showDetails(bookId) {
      this.$router.push({
        name: "BookDetails",
        params: { bookId },
      });
    },
  },
  mounted() {
    this.getBooksWithSearch();
  },
};
</script>
