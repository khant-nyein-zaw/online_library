<template>
  <div class="contact-us section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="section-heading">
            <h6>
              <router-link to="/register">Register</router-link> if you don't
              have an account.
            </h6>
            <h2>Login</h2>
            <p>
              Thank you for choosing our templates. We provide you best CSS
              templates at absolutely 100% free of charge. You may support us by
              sharing our website to your friends.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-us-content">
            <form id="contact-form" @submit.prevent="login">
              <div class="row">
                <div class="col-lg-12">
                  <fieldset>
                    <input
                      type="email"
                      v-model="fields.email"
                      id="email"
                      placeholder="Your E-mail..."
                      required
                    />
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input
                      type="password"
                      v-model="fields.password"
                      id="password"
                      placeholder="Your Password"
                      required
                    />
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button
                      type="submit"
                      id="form-submit"
                      class="orange-button"
                      :disabled="processing"
                    >
                      {{ processing ? "Please wait" : "Sign In" }}
                    </button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
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
            console.log(response.data);
          }
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
  },
};
</script>
