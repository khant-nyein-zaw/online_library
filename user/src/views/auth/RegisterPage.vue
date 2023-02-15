<template>
  <div class="row align-items-center justify-content-center g-0 min-vh-100">
    <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
      <!-- Card -->
      <div class="card smooth-shadow-md">
        <!-- Card body -->
        <div class="card-body p-6">
          <div class="mb-4">
            <router-link to="/"
              ><img
                src="assets/images/brand/logo/logo-primary.svg"
                class="mb-2"
                alt=""
            /></router-link>
            <p class="mb-6">Please enter your user information.</p>
          </div>
          <!-- Form -->
          <form @submit.prevent="register">
            <!-- validation errors -->
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors.email" :key="error">{{ error }}</li>
                <li v-for="error in errors.password" :key="error">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">User Name</label>
              <input
                type="text"
                id="username"
                class="form-control"
                v-model="fields.name"
                placeholder="User Name"
                required=""
              />
            </div>
            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                id="email"
                class="form-control"
                v-model="fields.email"
                placeholder="Email address here"
                required=""
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
                required=""
              />
            </div>
            <!-- Password -->
            <div class="mb-3">
              <label for="confirm-password" class="form-label"
                >Confirm Password</label
              >
              <input
                type="password"
                id="confirm-password"
                class="form-control"
                v-model="fields.password_confirmation"
                placeholder="**************"
                required=""
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
                  {{ processing ? "Please Wait" : "Create Account" }}
                </button>
              </div>

              <div class="d-md-flex justify-content-between mt-4">
                <div class="mb-2 mb-md-0">
                  <router-link to="/login" class="fs-5"
                    >Already member? Login
                  </router-link>
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
  name: "RegisterPage",
  data() {
    return {
      fields: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      processing: false,
      errors: null,
    };
  },
  methods: {
    ...mapActions(["login"]),
    register() {
      this.processing = true;
      this.axios
        .post("/api/register", this.fields)
        .then((response) => {
          if (response.data.user) {
            this.login(response.data);
          } else {
            this.errors = response.data.messages;
          }
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
  },
};
</script>
