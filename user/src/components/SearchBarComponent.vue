<template>
  <div class="d-flex justify-content-center">
    <!-- Form -->
    <form @submit.prevent="search" class="w-50 my-2">
      <input
        type="search"
        class="form-control form-control-sm"
        :class="{ 'is-invalid': isInputEmpty }"
        placeholder="Search your favorite books by author name or title"
        v-model="searchKey"
      />
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "SearchBarComponent",
  data() {
    return {
      searchKey: "",
      isInputEmpty: false,
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    search() {
      if (this.searchKey) {
        if (this.$route.name !== "BookList") {
          this.$router.push({
            name: "BookList",
            query: { searchKey: this.searchKey },
          });
        } else {
          this.$emit("refresh", this.searchKey);
        }
      } else {
        this.isInputEmpty = true;
      }
    },
  },
};
</script>
