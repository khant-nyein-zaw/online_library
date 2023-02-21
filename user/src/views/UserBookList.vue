<template>
  <div class="row">
    <div class="col-md-12 col-12">
      <!-- card  -->
      <div class="card" v-if="borrowings.length">
        <!-- card header  -->
        <div class="card-header bg-white py-4">
          <h4 class="mb-0">Your Books</h4>
        </div>
        <!-- table  -->
        <div class="table-responsive">
          <table class="table text-nowrap mb-0">
            <thead class="table-light">
              <tr>
                <th>Issue ID</th>
                <th>Book Title</th>
                <th>Category</th>
                <th>Period</th>
                <th>Issued Date</th>
                <th>Due Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="borrowing in borrowings" :key="borrowing.id">
                <td class="align-middle text-primary">{{ borrowing.id }}</td>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <span class="avatar avatar-sm" v-if="borrowing.book.image">
                      <img
                        alt="avatar"
                        :src="borrowing.book.image.filename"
                        class="rounded-circle"
                      />
                    </span>
                    <div class="ms-2 lh-1">
                      <h5 class="mb-1">
                        <router-link
                          :to="{
                            name: 'BookDetails',
                            params: { bookId: borrowing.book_id },
                          }"
                          class="text-inherit"
                        >
                          {{ borrowing.book.title }}
                        </router-link>
                      </h5>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <span class="badge bg-primary">{{
                    borrowing.book.category.name
                  }}</span>
                </td>
                <td class="align-middle">
                  <span :class="[borrowing.period <= 1 ? 'text-danger' : '']"
                    >{{ borrowing.period }}
                    {{ borrowing.period <= 1 ? "day" : "days" }}</span
                  >
                </td>
                <td class="align-middle">
                  <small>{{ borrowing.date_borrowed }}</small>
                </td>
                <td class="align-middle">
                  <small>{{ borrowing.due_date }}</small>
                </td>
                <td>
                  <button
                    @click="returnBook(borrowing.id)"
                    class="btn btn-sm btn-success"
                  >
                    Return
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Loading spinner -->
      <div class="text-center my-3" v-else-if="processing">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <!-- alert msg -->
      <div class="alert alert-secondary" v-else-if="!borrowings.length">
        <strong>There's no borrowed books for you now!</strong>
        <router-link to="/" class="ms-1"
          >Check out some of latest books.</router-link
        >
      </div>
    </div>
  </div>
  <Toast v-if="message" :message="message" @close="message = ''" />
</template>

<script>
import Toast from "@/components/ToastComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "UserBookList",
  components: { Toast },
  data() {
    return {
      borrowings: [],
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
    getBorrowedBooks() {
      this.processing = true;
      this.axios
        .get("/api/borrowings", {
          headers: this.headers,
        })
        .then((response) => {
          this.getImageUrl(response.data.borrowings);
          this.borrowings = response.data.borrowings;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
    returnBook(borrowing_id) {
      this.axios
        .post(
          "/api/returnings",
          {
            borrowing_id,
          },
          {
            headers: this.headers,
          }
        )
        .then((response) => {
          this.message = response.data.message;
        })
        .catch((err) => console.log(err))
        .finally(() => {
          setInterval(() => this.$router.push("/"), 3000);
        });
    },
    getImageUrl(borrowings) {
      borrowings.forEach((element) => {
        if (element.book.image) {
          element.book.image.filename =
            "http://localhost:8000/storage/" + element.book.image.filename;
        }
      });
    },
  },
  mounted() {
    this.getBorrowedBooks();
  },
};
</script>
