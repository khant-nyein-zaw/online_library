<template>
  <div class="container">
    <div class="row my-5" v-if="book">
      <div class="col-lg-5 offset-lg-2">
        <div class="card">
          <img :src="book.image.filename" class="card-img-top" />
          <div class="card-header">
            <h3 class="text-dark fw-bold text-uppercase text-center">
              {{ book.title }}
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

  <!-- Toast Noti -->
  <Toast v-if="message" :message="message" @close="message = ''" />
</template>

<script>
import Toast from "@/components/ToastComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "BookDetails",
  components: { Toast },
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
          response.data.book.image.filename =
            "http://localhost:8000/storage/" +
            response.data.book.image.filename;
          this.book = response.data.book;
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
  },
  mounted() {
    this.getBookDetails();
  },
};
</script>
