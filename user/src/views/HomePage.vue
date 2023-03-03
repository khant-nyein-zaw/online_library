<template>
  <div class="row">
    <div class="col-12 text-center">
      <h6>Books</h6>
      <h3>Recently added books</h3>
    </div>
    <!-- search bar for books -->
    <div class="row">
      <div class="col-12">
        <SearchBar />
      </div>
    </div>
    <div class="col-md-12 col-12 mt-5" v-if="bookList.length">
      <!-- card  -->
      <div class="row">
        <div
          class="col-12 col-sm-6 col-md-4"
          v-for="book in bookList"
          :key="book.id"
        >
          <!-- image overlay -->
          <div class="card mb-3 bg-dark text-center">
            <div
              class="card-body"
              @click.self="
                $router.push({
                  name: 'BookDetails',
                  params: { bookId: book.id },
                })
              "
            >
              <h2 class="card-title mb-3 text-white">
                {{ book.title }}
              </h2>
              <h5 class="card-title text-white">
                {{ book.author.name }}
              </h5>
              <h6 class="card-subtitle text-white mb-3">
                {{ book.category.name }}
              </h6>
              <button
                class="btn btn-outline-info btn-sm"
                @click="
                  $router.push({
                    name: 'LendRequest',
                    params: {
                      bookId: book.id,
                    },
                  })
                "
              >
                Lend
              </button>
            </div>
            <img
              v-if="book.image"
              :src="book.image.filename"
              class="card-img-bottom"
              alt="..."
            />
          </div>
        </div>
      </div>
    </div>
    <!-- Loading spinner -->
    <div
      class="row justify-content-center align-items-center min-vh-100"
      v-else-if="processing"
    >
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
import SearchBar from "@/components/SearchBarComponent.vue";
import { mapGetters } from "vuex";

export default {
  name: "HomePage",
  components: { SearchBar },
  data() {
    return {
      bookList: [],
      processing: false,
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
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
        if (book.image) {
          book.image.filename =
            "http://localhost:8000/storage/" + book.image.filename;
        }
      });
    },
  },
  mounted() {
    this.getBookList();
  },
};
</script>
