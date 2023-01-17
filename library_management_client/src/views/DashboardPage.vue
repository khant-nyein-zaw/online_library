<template>
  <div class="row mb-4">
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start">
            <div class="avatar flex-shrink-0">
              <i class="bx bxs-book-content fs-2 text-success rounded"></i>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Rented Books</span>
          <h3 class="card-title mb-2">9</h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start">
            <div class="avatar flex-shrink-0">
              <i class="bx bxs-book-content fs-2 text-primary rounded"></i>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Books</span>
          <h3 class="card-title mb-2">9</h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start">
            <div class="avatar flex-shrink-0">
              <i class="bx bxs-book-content fs-2 text-danger rounded"></i>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Not returned</span>
          <h3 class="card-title mb-2">9</h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start">
            <div class="avatar flex-shrink-0">
              <i class="bx bxs-book-content fs-2 text-info rounded"></i>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Available Books</span>
          <h3 class="card-title mb-2">9</h3>
        </div>
      </div>
    </div>
  </div>
  <!-- Book List -->
  <div class="row" v-if="bookList.length">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Book List</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Date of publication</th>
                <th>Category</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="book in bookList" :key="book.id">
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-l pull-up" v-if="book.image">
                      <img
                        :src="book.image.filename"
                        alt="Avatar"
                        class="rounded-circle"
                      />
                    </div>
                    <div class="avatar avatar-l pull-up" v-else>
                      <img
                        src="assets/img/avatars/5.png"
                        alt="Avatar"
                        class="rounded-circle"
                      />
                    </div>
                    <strong>{{ book.title }}</strong>
                  </div>
                </td>
                <td>{{ book.author }}</td>
                <td>
                  <span class="badge bg-label-primary me-1">{{
                    book.publisher
                  }}</span>
                </td>
                <td>
                  {{ book.date_published }}
                </td>
                <td>{{ book.category.name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div v-if="processing" class="d-flex justify-content-center mt-5">
    <div class="demo-inline-spacing">
      <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DashboardPage",
  data() {
    return {
      bookList: [],
      processing: false,
    };
  },
  methods: {
    getBookList() {
      this.processing = true;
      this.axios
        .get("/api/books")
        .then((res) => {
          res.data.books.forEach((book) => {
            if (book.image) {
              book.image.filename =
                "http://localhost:8000/storage/" + book.image.filename;
            }
          });
          this.bookList = res.data.books;
          this.processing = false;
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    this.getBookList();
  },
};
</script>
