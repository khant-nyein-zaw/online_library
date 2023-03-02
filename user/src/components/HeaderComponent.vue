<template>
  <div class="header">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
      <a id="nav-toggle" href="#">
        <i class="fa-solid fa-bars nav-icon icon-xs me-2"></i>
      </a>
      <!--Navbar nav -->
      <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
        <li class="dropdown stopevent">
          <a
            class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted position-relative"
            href="#"
            role="button"
            id="dropdownNotification"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fa-solid fa-bell me-1 icon-xxs"></i>
            <span
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              v-if="notifications.length"
            >
              {{ notifications.length }}
              <span class="visually-hidden">unread messages</span>
            </span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
            aria-labelledby="dropdownNotification"
          >
            <div>
              <div
                class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center"
              >
                <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
              </div>
              <!-- List group -->
              <ul class="list-group list-group-flush notification-list-scroll">
                <!-- List group item -->
                <li
                  class="list-group-item"
                  :class="{ 'bg-light': !markAsRead }"
                  v-for="noti in notifications"
                  :key="noti.id"
                  @click="markNotiAsRead(noti.id)"
                >
                  <a href="#" class="text-muted">
                    <h5 class="mb-1 text-primary">
                      Overdue Notice for {{ noti.data["bookTitle"] }}
                    </h5>
                    <p class="mb-0">
                      {{ noti.data["bookTitle"] }} have expired due date.Please
                      return as soon as possible and pay
                      {{ noti.data["fine"] }} kyats as fine.
                    </p>
                  </a>
                </li>
                <li
                  class="list-group-item bg-light"
                  v-if="!notifications.length"
                >
                  <h6 class="text-muted">No Notifications</h6>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "HeaderComponent",
  data() {
    return {
      notifications: [],
      markAsRead: false,
    };
  },
  computed: {
    ...mapGetters({
      headers: "getHeaders",
    }),
  },
  methods: {
    getUnreadNotifications() {
      this.axios
        .get("/api/notifications", { headers: this.headers })
        .then((response) => (this.notifications = response.data.notifications));
    },
    markNotiAsRead(id) {
      this.markAsRead = true;
      this.axios
        .post("/api/mark-notification", { id }, { headers: this.headers })
        .then((response) => console.log(response.data))
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    if (this.headers.Authorization) {
      this.getUnreadNotifications();
    }
  },
};
</script>
