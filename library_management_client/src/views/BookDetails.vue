<template>
  <div class="section testimonials" v-if="book">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="card">
            <img :src="book.image.filename" class="card-img-top" />
            <div class="card-body">
              <h3 class="card-title">{{ book.category.name }}</h3>
              <p class="card-text mb-0">
                Date of publication - {{ book.date_published }}
              </p>
              <p class="card-text">Shelf Number - {{ book.shelf.shelf_no }}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-5 align-self-center">
          <div class="section-heading">
            <h6>{{ book.author }}</h6>
            <h2>{{ book.title }}</h2>
            <b class="d-block mb-3">
              {{ book.publisher }}
            </b>
            <button class="btn btn-primary">Lend</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
    };
  },
  methods: {
    getBookDetails() {
      this.axios
        .get(`/api/books/${this.bookId}`)
        .then((response) => {
          response.data.book.image.filename =
            "http://localhost:8000/storage/" +
            response.data.book.image.filename;
          this.book = response.data.book;
          console.log(this.book);
        })
        .catch((err) => console.log(err));
    },
    // requestToBorrow() {
    //   this.axios.post("/");
    // },
  },
  mounted() {
    this.getBookDetails();
  },
};
</script>
