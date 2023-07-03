<template>
  <div class="row align-items-center">
    <div class="col-12 col-md-6 mx-md-auto">
      <!-- Card -->
      <div class="card smooth-shadow-md mx-xl-10">
        <!-- Card body -->
        <div class="card-body p-6">
          <div class="mb-4">
            <a href="#">
              <h3 class="fw-bold text-primary">Online Library</h3>
            </a>
            <small> Please fill how many days you want to lend </small>
          </div>
          <!-- Form -->
          <form @submit.prevent="makeLendRequest">
            <!-- Validation Errors -->
            <div class="alert alert-danger" v-if="errors.duration">
              <ul>
                <li v-for="e in errors.duration" :key="e">{{ e }}</li>
              </ul>
            </div>
            <!-- duration for lending books -->
            <div class="mb-3">
              <label for="duration" class="form-label">Duration</label>
              <input
                type="number"
                id="duration"
                class="form-control"
                v-model="fields.duration"
                placeholder="eg. 10 days"
              />
            </div>
            <div>
              <!-- Button -->
              <div class="d-grid">
                <button
                  type="submit"
                  class="btn btn-primary"
                  :disabled="processing"
                >
                  {{ processing ? "Please Wait" : "Submit" }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 mx-md-auto p-3">
      <div
        class="card cursor-pointer"
        v-if="book"
        @click="
          $router.push({
            name: 'BookDetails',
            params: { bookId: book.id },
          })
        "
      >
        <img :src="book.image.filename" class="card-img-top" />
        <div class="card-body">
          <h6 class="card-text text-muted">{{ book.author.name }}</h6>
        </div>
      </div>
      <!-- Loading Spinner -->
      <div
        class="d-flex justify-content-center align-items-center"
        v-else-if="loading"
      >
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>

    <!-- Toast Noti -->
    <Toast v-if="message" :message="message" @close="message = ''" />
  </div>
</template>

<script>
import Toast from "@/components/ToastComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "LendRequestPage",
  components: { Toast },
  props: ["bookId"],
  data() {
    return {
      book: null,
      fields: {
        user_id: "",
        book_id: parseInt(this.bookId),
        duration: "",
      },
      loading: false,
      processing: false,
      message: "",
      errors: {},
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
      user: "getUser",
    }),
  },
  methods: {
    makeLendRequest() {
      this.processing = true;
      this.axios
        .post("/api/lend-requests", this.fields, {
          headers: this.headers,
        })
        .then((response) => {
          if (response.data.messages) {
            this.errors = response.data.messages;
          } else if (response.data.message) {
            this.message =
              response.data.message +
              " Please wait for library staff's response";
            this.fields.duration = "";
            this.errors = {};
          } else {
            this.fields.duration = "";
            this.errors = {};
            this.message =
              "Request to lend the book has been made.Please wait for library staff's response";
          }
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
    getBookDetails() {
      this.loading = true;
      this.axios
        .get(`/api/books/${this.bookId}`, { headers: this.headers })
        .then((response) => {
          response.data.book.image.filename =
            "http://localhost:8000/storage/" +
            response.data.book.image.filename;
          this.book = response.data.book;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
    },
  },
  mounted() {
    this.fields.user_id = this.user.user.id;
  },
  created() {
    this.getBookDetails();
  },
};
</script>
