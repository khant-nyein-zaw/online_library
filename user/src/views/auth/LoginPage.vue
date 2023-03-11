<template>
  <div class="row align-items-center justify-content-center g-0 min-vh-100">
    <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
      <!-- Card -->
      <div class="card smooth-shadow-md">
        <!-- Card body -->
        <div class="card-body p-6">
          <div class="mb-4">
            <a href="#"
              ><img
                src="assets/images/brand/logo/logo-primary.svg"
                class="mb-2"
                alt=""
            /></a>
            <p class="mb-6">Please enter your user information.</p>
          </div>
          <!-- Form -->
          <form @submit.prevent="login">
            <!-- Validation Errors -->
            <div class="alert alert-danger" v-if="message">
              {{ message }}
            </div>

            <!-- Username -->
            <div class="mb-3">
              <label for="email" class="form-label">Username or email</label>
              <input
                type="email"
                id="email"
                class="form-control"
                v-model="fields.email"
                placeholder="Email address here"
                required
              />
            </div>
            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                id="password"
                class="form-control"
                v-model="fields.password"
                placeholder="**************"
                required
              />
            </div>
            <div>
              <!-- Button -->
              <div class="d-grid">
                <button
                  type="submit"
                  class="btn btn-primary"
                  :disabled="processing"
                >
                  {{ processing ? "Please Wait" : "Sign In" }}
                </button>
              </div>

              <div class="d-md-flex justify-content-between mt-4">
                <div class="mb-2 mb-md-0">
                  <router-link to="/register" class="fs-5"
                    >Create An Account</router-link
                  >
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "LoginPage",
  data() {
    return {
      fields: {
        email: "",
        password: "",
      },
      processing: false,
      message: "",
    };
  },
  methods: {
    ...mapActions({
      signIn: "login",
    }),
    async login() {
      this.processing = true;
      await this.axios.get("/sanctum/csrf-cookie");
      await this.axios
        .post("/api/login", this.fields)
        .then((response) => {
          if (response.data.user) {
            this.signIn(response.data);
          } else {
            this.message = response.data.message;
          }
        })
        .catch((err) => {
          if (err.response.status === 403) {
            this.message = "The credentials are failed to authorize";
          }
        })
        .finally(() => (this.processing = false));
    },
  },
};
</script>
