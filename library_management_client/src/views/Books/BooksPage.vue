<template>
  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div
          class="card-header d-flex justify-content-between align-items-center"
        >
          <h5 class="mb-0">Add New Book</h5>
          <small class="text-muted float-end">Book Informations</small>
        </div>
        <div class="card-body">
          <form @submit.prevent="createNewBook">
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input
                type="text"
                class="form-control"
                v-model="fields.title"
                placeholder="eg. Game of Thrones"
              />
              <div class="alert alert-danger mt-2" v-if="errors.title">
                <small v-for="error in errors.title" :key="error">{{
                  error
                }}</small>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Author</label>
              <input
                type="text"
                class="form-control"
                v-model="fields.author"
                placeholder="eg. J. K. Rowling"
              />
              <div class="alert alert-danger mt-2" v-if="errors.author">
                <small v-for="error in errors.author" :key="error">{{
                  error
                }}</small>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Publisher</label>
              <input
                type="text"
                class="form-control"
                v-model="fields.publisher"
                placeholder="eg. Bloomsbury"
              />
              <div class="alert alert-danger mt-2" v-if="errors.publisher">
                <small v-for="error in errors.publisher" :key="error">{{
                  error
                }}</small>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Date of publication</label>
              <input
                type="date"
                class="form-control"
                v-model="fields.date_published"
              />
              <div class="alert alert-danger mt-2" v-if="errors.date_published">
                <small v-for="error in errors.date_published" :key="error">{{
                  error
                }}</small>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Category of Book</label>
              <input
                type="text"
                class="form-control"
                v-model="fields.category"
                placeholder="eg. Fantasy Fiction"
              />
              <div class="alert alert-danger mt-2" v-if="errors.category">
                <small v-for="error in errors.category" :key="error">{{
                  error
                }}</small>
              </div>
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Photo</label>
              <input type="file" class="form-control" />
            </div> -->
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BooksPage",
  data() {
    return {
      fields: {
        title: "",
        author: "",
        publisher: "",
        date_published: "",
        category: "",
      },
      errors: {},
    };
  },
  methods: {
    createNewBook() {
      this.axios
        .post("/api/books", this.fields)
        .then((res) => {
          console.log(res.data);
          if (res.data.message == "Validation failed") {
            this.errors = res.data.errors;
          }
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
