<template>
  <div class="row">
    <div class="col-md-12 col-12">
      <!-- card  -->
      <div class="card" v-if="issuedBooks.length">
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
                <th>Remaining Period</th>
                <th>Status</th>
                <th>Due Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="issue in issuedBooks" :key="issue.id">
                <td class="align-middle text-primary">{{ issue.id }}</td>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <span class="avatar avatar-sm" v-if="issue.book.image">
                      <img
                        alt="avatar"
                        v-if="issue.book.image"
                        :src="issue.book.image.filename"
                        class="rounded-circle"
                      />
                    </span>
                    <div class="ms-2 lh-1">
                      <h5 class="mb-1">
                        <router-link
                          :to="{
                            name: 'BookDetails',
                            params: { bookId: issue.book_id },
                          }"
                          class="text-inherit"
                        >
                          {{ issue.book.title }}
                        </router-link>
                      </h5>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <span class="badge bg-primary">{{
                    issue.book.category.name
                  }}</span>
                </td>
                <td class="align-middle">
                  <small class="text-primary">{{ issue.period }}</small>
                </td>
                <td class="align-middle">
                  <span
                    class="badge"
                    :class="{
                      'bg-danger': issue.status === 'overdue',
                      'bg-primary': issue.status === 'issued',
                      'bg-success': issue.status === 'returned',
                    }"
                    >{{ issue.status }}</span
                  >
                </td>
                <td class="align-middle">
                  <small>{{ issue.due_date }}</small>
                </td>
                <td v-if="issue.status === 'issued'">
                  <button
                    @click="changeStatus(issue.id)"
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
      <div class="alert alert-secondary" v-else-if="!issuedBooks.length">
        <strong>There's no borrowed books for you now!</strong>
        <router-link to="/" class="ms-1"
          >Check out some of latest books.</router-link
        >
      </div>
    </div>
  </div>
  <Toast v-if="message" :message="message" reload @close="message = ''" />
</template>

<script>
import Toast from "@/components/ToastComponent.vue";
import { mapGetters } from "vuex";
export default {
  name: "UserBookList",
  components: { Toast },
  data() {
    return {
      issuedBooks: [],
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
        .get("/api/user-issued-books", {
          headers: this.headers,
        })
        .then((response) => {
          this.getImageUrl(response.data.issuedBooks);
          this.issuedBooks = response.data.issuedBooks;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
    changeStatus(issueId) {
      this.axios
        .patch(
          `/api/user-issued-books/${issueId}`,
          {
            issueId,
          },
          {
            headers: this.headers,
          }
        )
        .then((response) => {
          if (response.data.message) {
            this.message = response.data.message;
            setTimeout(() => location.reload(), 5000);
          }
        })
        .catch((err) => console.log(err));
    },
    getImageUrl(issuedBooks) {
      issuedBooks.forEach((element) => {
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
