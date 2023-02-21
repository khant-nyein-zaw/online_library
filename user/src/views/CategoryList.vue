<template>
  <div class="row my-3">
    <div class="col-12 text-center mb-4">
      <h6>Categories</h6>
      <h2>Most Popular Categories</h2>
    </div>
    <div class="col-lg-12" v-for="category in categories" :key="category.id">
      <div class="card">
        <div class="card-header text-center">
          <h3 class="text-primary">{{ category.name }}</h3>
          <small
            >{{ category.books.length }}
            {{ category.books.length > 1 ? "books" : "book" }} in this
            category</small
          >
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-6" v-for="book in category.books" :key="book.id">
              <div
                class="card cursor-pointer"
                @click="
                  $router.push({
                    name: 'BookDetails',
                    params: { bookId: book.id },
                  })
                "
              >
                <img :src="book.image.filename" class="card-img-top" />
                <div class="card-body">
                  <h6 class="card-text text-muted">{{ book.author }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "CategoryList",
  data() {
    return {
      categories: [],
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    getCategories() {
      this.axios
        .get("/api/categories", { headers: this.headers })
        .then((response) => {
          response.data.categories.forEach((category) =>
            this.getImageUrl(category.books)
          );
          this.categories = response.data.categories;
        })
        .catch((err) => console.log(err));
    },
    getImageUrl(books) {
      books.forEach((book) => {
        book.image.filename =
          "http://localhost:8000/storage/" + book.image.filename;
      });
    },
  },
  mounted() {
    this.getCategories();
  },
};
</script>
