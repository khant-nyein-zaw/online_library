<template>
  <div class="container services section">
    <div class="row my-3">
      <div class="section-heading">
        <div class="col-12 text-center">
          <h6>Categories</h6>
          <h2>Most Popular Categories</h2>
        </div>
      </div>
      <div class="col-lg-4" v-for="category in categories" :key="category.id">
        <div class="service-item">
          <div class="main-content">
            <h4>{{ category.name }}</h4>
            <p>Books - {{ category.books_count }}</p>
            <div class="main-button">
              <router-link
                :to="{
                  name: 'CategoryBookList',
                  params: {
                    categoryId: category.id,
                  },
                }"
              >
                View More
              </router-link>
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
          this.categories = response.data.categories;
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    this.getCategories();
  },
};
</script>
