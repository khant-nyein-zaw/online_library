<template>
  <div class="container">
    <div class="row my-5" v-if="book">
      <div class="col-lg-5 offset-lg-2">
        <div class="card">
          <img
            v-if="book.image"
            :src="book.image.filename"
            class="card-img-top"
          />
          <div class="card-header">
            <h3 class="text-dark fw-bold text-uppercase text-center">
              {{ book.title }}
            </h3>
          </div>
        </div>
      </div>
      <div class="col-lg-5 align-self-center">
        <h6>{{ book.author.name }}</h6>
        <h2>{{ book.category.name }}</h2>
        <b class="d-block mb-3">
          {{ book.publisher }}
        </b>
        <div class="d-flex gap-2 align-items-center">
          <button
            class="btn btn-dark btn-sm"
            @click="
              $router.push({
                name: 'LendRequest',
                params: {
                  bookId: book.id,
                },
              })
            "
          >
            Borrow
          </button>
          <button class="btn btn-primary btn-sm" @click="$router.back()">
            Back
          </button>
        </div>
      </div>
    </div>
    <div
      class="row justify-content-center align-items-center min-vh-100"
      v-else-if="processing"
    >
      <!-- Loading spinner -->
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "BookDetails",
  props: {
    bookId: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      book: null,
      message: "",
      processing: false,
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
      user: "getUser",
    }),
  },
  methods: {
    getBookDetails() {
      this.processing = true;
      this.axios
        .get(`/api/books/${this.bookId}`, { headers: this.headers })
        .then((response) => {
          if (response.data.book.image) {
            response.data.book.image.filename =
              "http://localhost:8000/storage/" +
              response.data.book.image.filename;
          }
          this.book = response.data.book;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
  },
  mounted() {
    this.getBookDetails();
  },
};
</script>
