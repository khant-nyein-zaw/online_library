<template>
  <div class="row">
    <div class="col-md-12 col-12">
      <!-- card  -->
      <div class="card" v-if="bookList.length">
        <!-- card header  -->
        <div class="card-header bg-white py-4">
          <h4 class="mb-0">Recently added books</h4>
        </div>
        <!-- table  -->
        <div class="table-responsive">
          <table class="table text-nowrap mb-0">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Shelf No</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="book in bookList" :key="book.id">
                <td>{{ book.id }}</td>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <span class="avatar avatar-sm">
                      <img
                        alt="avatar"
                        :src="book.image.filename"
                        class="rounded-circle"
                      />
                    </span>
                    <div class="ms-3 lh-1">
                      <h5 class="mb-1">
                        <router-link
                          :to="{
                            name: 'BookDetails',
                            params: { bookId: book.id },
                          }"
                          class="text-inherit"
                          >{{ book.title }}</router-link
                        >
                      </h5>
                    </div>
                  </div>
                </td>
                <td class="align-middle">{{ book.author }}</td>
                <td class="align-middle">
                  <span class="badge bg-primary">{{ book.category.name }}</span>
                </td>
                <td class="align-middle">{{ book.shelf.shelf_no }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- card footer  -->
        <div class="card-footer bg-white text-center">
          <a href="#" class="link-primary">View All Books</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "HomePage",
  data() {
    return {
      categories: [],
      bookList: [],
      searchKey: "",
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    getBookList() {
      this.axios
        .get("/api/books", { headers: this.headers })
        .then((response) => {
          this.getImageUrl(response.data.books);
          this.bookList = response.data.books;
        })
        .catch((err) => console.log(err));
    },
    getImageUrl(books) {
      books.forEach((book) => {
        book.image.filename =
          "http://localhost:8000/storage/" + book.image.filename;
      });
    },
    getCategories() {
      this.axios
        .get("/api/categories", { headers: this.headers })
        .then((response) => {
          this.categories = response.data.categories;
        })
        .catch((err) => console.log(err));
    },
    search() {
      if (this.searchKey) {
        this.$router.push({
          name: "BookList",
          query: { searchKey: this.searchKey },
        });
      } else {
        alert("Please fill searchKey first");
      }
    },
  },
  mounted() {
    this.getCategories();
    this.getBookList();
  },
};
</script>
