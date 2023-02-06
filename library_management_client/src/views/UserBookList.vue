<template>
  <div class="container section">
    <!-- Table Dark -->
    <div class="row my-5">
      <div class="col-12">
        <!-- Card -->
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Borrowed Book List</h6>
            <h2>{{ user.user.name }}'s Books</h2>
          </div>
        </div>
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Issue ID</th>
                    <th scope="col">Book ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Period</th>
                    <th scope="col">Borrowed Date</th>
                    <th scope="col">Due Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="borrowing in borrowings" :key="borrowing.id">
                    <th scope="row">
                      <a href="#">{{ borrowing.id }}</a>
                    </th>
                    <td>{{ borrowing.book_id }}</td>
                    <td>
                      <h6 class="text-primary">{{ borrowing.book.title }}</h6>
                    </td>
                    <td>{{ borrowing.period }} days</td>
                    <td>{{ borrowing.date_borrowed }}</td>
                    <td>{{ borrowing.due_date }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Table dark -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "UserBookList",
  data() {
    return {
      borrowings: [],
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
      this.axios
        .get("/api/borrowings", {
          headers: this.headers,
        })
        .then((response) => {
          this.borrowings = response.data.borrowings;
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    this.getBorrowedBooks();
  },
};
</script>
