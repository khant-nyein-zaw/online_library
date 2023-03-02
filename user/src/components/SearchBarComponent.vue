<template>
  <!-- Form -->
  <div class="card my-2">
    <div class="card-body py-1">
      <form @submit.prevent="search" class="w-50 mx-auto">
        <input
          type="search"
          class="form-control border border-0"
          :class="{ 'is-invalid': isInputEmpty }"
          placeholder="Search your favorite books by author name, title, ISBN or category"
          v-model="searchKey"
        />
      </form>
    </div>
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
