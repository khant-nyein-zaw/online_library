<template>
  <div class="contact-us section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="section-heading">
            <h6>
              <router-link to="/login">Login</router-link> if you already have
              an account.
            </h6>
            <h2>Register</h2>
            <p>
              Thank you for choosing our templates. We provide you best CSS
              templates at absolutely 100% free of charge. You may support us by
              sharing our website to your friends.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-us-content">
            <form id="contact-form" @submit.prevent="register">
              <div class="row">
                <div class="col-lg-12">
                  <fieldset>
                    <input
                      type="text"
                      v-model="fields.name"
                      id="name"
                      placeholder="Your Name..."
                      required
                    />
                  </fieldset>
                </div>
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
                      placeholder="Your Password..."
                      required
                    />
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input
                      type="password"
                      v-model="fields.password_confirmation"
                      id="password_confirmation"
                      placeholder="Confirm Your Password..."
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
                      {{ processing ? "Please wait" : "Sign Up" }}
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
            console.log(response.data);
          }
        })
        .catch((err) => console.log(err))
        .finally(() => (this.processing = false));
    },
  },
};
</script>
