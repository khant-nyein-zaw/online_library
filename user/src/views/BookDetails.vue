<template>
  <div class="container" v-if="book">
    <div class="row">
      <div class="col-lg-5 offset-lg-2">
        <div class="card">
          <img :src="book.image.filename" class="card-img-top" />
          <div class="card-header">
            <h3>
              <a href="#">{{ book.title }}</a>
            </h3>
          </div>
        </div>
      </div>
      <div class="col-lg-5 align-self-center">
        <h6>{{ book.author }}</h6>
        <h2>{{ book.category.name }}</h2>
        <b class="d-block mb-3">
          {{ book.publisher }}
        </b>
        <div class="d-flex gap-2 align-items-center">
          <button class="btn btn-dark btn-sm" @click="sendRequest(book.id)">
            Borrow
          </button>
          <button class="btn btn-primary btn-sm" @click="$router.back()">
            Back
          </button>
        </div>
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
      this.axios
        .get(`/api/books/${this.bookId}`, { headers: this.headers })
        .then((response) => {
          response.data.book.image.filename =
            "http://localhost:8000/storage/" +
            response.data.book.image.filename;
          this.book = response.data.book;
        })
        .catch((err) => console.log(err));
    },
    sendRequest(book_id) {
      this.axios
        .post(
          "/api/borrow-requests",
          { user_id: this.user.user.id, book_id },
          { headers: this.headers }
        )
        .then((response) => {
          console.log(response.data);
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    this.getBookDetails();
  },
};
</script>
