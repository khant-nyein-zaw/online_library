import { createStore } from "vuex";
import router from "@/router";
import axios from "axios";

const user = JSON.parse(localStorage.getItem("user"));
const headers = user
  ? {
      Authorization: `Bearer ${user.access_token}`,
    }
  : {};
const authenticated = user ? true : false;

export default createStore({
  state: {
    authenticated,
    user,
    headers,
    notifications: [],
  },
  getters: {
    getUser: (state) => state.user,
    getHeaders: (state) => state.headers,
    getNotifications: (state) => (state = state.notifications),
  },
  mutations: {
    set_authenticated: (state, value) => {
      state.authenticated = value;
    },
    set_user: (state, value) => {
      state.user = value;
    },
    set_headers: (state, value) => {
      state.headers = {
        Authorization: `Bearer ${value.access_token}`,
      };
    },
    remove_headers: (state, value) => {
      state.headers = value;
    },
    set_notifications: (state, value) => {
      state.notifications = value;
    },
  },
  actions: {
    login: ({ commit }, data) => {
      localStorage.setItem("user", JSON.stringify(data));
      commit("set_user", data);
      commit("set_authenticated", true);
      commit("set_headers", data);
      router.push({ name: "Home" });
    },
    logout: ({ commit }) => {
      commit("set_user", null);
      commit("set_authenticated", false);
      commit("remove_headers", {});
      localStorage.removeItem("user");
    },
    getUserNotifications: ({ getters, commit }) => {
      axios
        .get("/api/notifications", {
          headers: getters.getHeaders,
        })
        .then((response) =>
          commit("set_notifications", response.data.notifications)
        )
        .catch((err) => console.log(err));
    },
  },
  modules: {},
});
