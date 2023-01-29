<template>
  <div class="section events" id="events">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Books</h6>
            <h2>Most popular books in library</h2>
          </div>
          <div class="col-3 offset-9 mb-4">
            <select class="form-control" v-model="sortBy" @change="sort">
              <option value="">Choose Option</option>
              <option value="asc">Earliest</option>
              <option value="desc">Latest</option>
            </select>
          </div>
        </div>
        <div class="col-lg-12 col-md-6" v-for="book in bookList" :key="book.id">
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
                <div class="image">
                  <img :src="book.image.filename" alt="" />
                </div>
              </div>
              <div class="col-lg-9">
                <ul>
                  <li>
                    <span class="category">{{ book.category.name }}</span>
                    <h4>{{ book.title }}</h4>
                  </li>
                  <li>
                    <span>Author</span>
                    <h6>{{ book.author }}</h6>
                  </li>
                  <li>
                    <span>Publisher</span>
                    <h6>{{ book.publisher }}</h6>
                  </li>
                  <li>
                    <span>Shelf</span>
                    <h6>{{ book.shelf.shelf_no }}</h6>
                  </li>
                </ul>
                <a href="#"><i class="fa fa-angle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BookList",
  data() {
    return {
      bookList: [],
      sortBy: "",
    };
  },
  methods: {
    getBookList() {
      this.axios
        .get("/api/books")
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
    sort() {
      if (this.sortBy) {
        this.axios
          .get(`/api/books/${this.sortBy}/all`)
          .then((response) => {
            this.getImageUrl(response.data.books);
            this.bookList = response.data.books;
          })
          .catch((err) => console.log(err));
      }
    },
  },
  mounted() {
    this.getBookList();
  },
};
</script>
