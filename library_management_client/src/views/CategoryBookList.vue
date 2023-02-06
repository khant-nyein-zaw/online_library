<template>
  <div class="section events" id="events">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Books</h6>
            <h2>{{ categoryId }}</h2>
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
                <a href="#" @click="showDetails(book.id)"
                  ><i class="fa fa-angle-right"></i
                ></a>
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
  name: "CategoryBookList",
  props: {
    categoryId: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      bookList: [],
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    getBooksInCategory() {
      console.log("running");
    },
  },
  mounted() {
    this.getBooksInCategory();
  },
};
</script>
