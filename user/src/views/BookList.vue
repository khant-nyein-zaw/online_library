<template>
  <div class="row">
    <div class="col-12 text-center mb-3">
      <h6>Search Results</h6>
      <h2
        v-if="!isEditing"
        @dblclick="isEditing = !isEditing"
        class="cursor-pointer"
      >
        {{ searchKey }}
      </h2>
      <SearchBar
        v-if="isEditing"
        @refresh="getBooksWithSearch"
        @dblclick="isEditing = !isEditing"
      />
    </div>
    <div class="col-12" v-if="bookList.length">
      <div class="row">
        <div class="col-12 mb-3">
          <div class="float-end">
            <select
              v-model="sortBy"
              class="form-select form-select-sm"
              @change="sort"
            >
              <option value="">Sorting</option>
              <option value="asc">Oldest</option>
              <option value="desc">Latest</option>
            </select>
          </div>
        </div>
        <div
          class="col-12 col-lg-6 col-xl-4"
          v-for="book in bookList"
          :key="book.id"
        >
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
    <!-- search not found alert -->
    <div class="col-12" v-else-if="notFound">
      <div class="alert alert-danger">
        <small>No Matching Results.</small>
      </div>
    </div>
  </div>
  <!-- Toast Noti -->
  <Toast v-if="message" :message="message" />
</template>

<script>
import Toast from "@/components/ToastComponent.vue";
import SearchBar from "@/components/SearchBarComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "BookList",
  components: { Toast, SearchBar },
  data() {
    return {
      searchKey: "",
      bookList: [],
      sortBy: "",
      message: "",
      processing: false,
      notFound: false,
      isEditing: false,
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
      user: "getUser",
    }),
  },
  methods: {
    sort() {
      this.processing = true;
      if (this.sortBy) {
        this.axios
          .post(
            `/api/books/search`,
            {
              searchKey: this.searchKey,
              sortBy: this.sortBy,
            },
            {
              headers: this.headers,
            }
          )
          .then((response) => {
            this.getImageUrl(response.data.books);
            this.bookList = response.data.books;
          })
          .catch((err) => console.log(err))
          .finally(() => (this.processing = false));
      }
    },
    getBooksWithSearch(searchKey) {
      this.searchKey = searchKey;
      while (this.bookList.length) {
        this.bookList.pop();
      }
      this.processing = true;
      this.axios
        .post(
          `/api/books/search`,
          {
            searchKey,
          },
          {
            headers: this.headers,
          }
        )
        .then((response) => {
          if (response.data.books.length) {
            this.getImageUrl(response.data.books);
            this.bookList = response.data.books;
          } else {
            this.notFound = true;
          }
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
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
    this.searchKey = this.$route.query.searchKey;
    this.getBooksWithSearch(this.searchKey);
  },
  updated() {
    this.$route.query.searchKey = this.searchKey;
  },
};
</script>
