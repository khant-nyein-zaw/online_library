<template>
  <div class="row">
    <div class="col-12 text-center">
      <h6>Books</h6>
      <h3>Recently added books</h3>
    </div>
    <!-- search bar for books -->
    <SearchBar />
    <div class="col-md-12 col-12 mt-5" v-if="bookList.length">
      <!-- card  -->
      <div class="row">
        <div class="col-12 col-lg-6" v-for="book in bookList" :key="book.id">
          <!-- image overlay -->
          <div class="card mb-3 bg-dark text-center">
            <div class="card-body">
              <h2 class="card-title mb-3 text-white">
                {{ book.title }}
              </h2>
              <h5 class="card-title text-white">
                {{ book.author }}
              </h5>
              <h6 class="card-subtitle text-white mb-3">
                {{ book.category.name }}
              </h6>
              <button
                class="btn btn-outline-info btn-sm"
                @click="sendRequest(book.id)"
              >
                Borrow
              </button>
            </div>
            <img :src="book.image.filename" class="card-img-bottom" alt="..." />
          </div>
        </div>
      </div>
    </div>
    <!-- Loading spinner -->
    <div class="text-center my-3" v-else-if="processing">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <Toast v-if="message" :message="message" @close="message = ''" />
</template>

<script>
import SearchBar from "@/components/SearchBarComponent.vue";
import Toast from "@/components/ToastComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "HomePage",
  components: { SearchBar, Toast },
  data() {
    return {
      bookList: [],
      processing: false,
      message: "",
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
      user: "getUser",
    }),
  },
  methods: {
    getBookList() {
      this.processing = true;
      this.axios
        .get("/api/books", { headers: this.headers })
        .then((response) => {
          this.getImageUrl(response.data.books);
          this.bookList = response.data.books;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
    getImageUrl(books) {
      books.forEach((book) => {
        book.image.filename =
          "http://localhost:8000/storage/" + book.image.filename;
      });
    },
    sendRequest(book_id) {
      this.axios
        .post(
          "/api/borrow-requests",
          { user_id: this.user.user.id, book_id },
          { headers: this.headers }
        )
        .then((response) => {
          this.message = response.data.message;
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    this.getBookList();
  },
};
</script>
