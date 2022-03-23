<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <nav-search/>

      <!-- Messages Dropdown Menu -->
      <nav-messages/>

      <!-- Notifications Dropdown Menu -->
      <nav-notifications/>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- Control Sidebar -->
      <nav-control-sidebar/>
    </ul>
  </nav>
</template>

<script>
import NavSearch from "./NavSearch.vue"
import NavMessages from "./NavMessages.vue"
import NavNotifications from "./NavNotifications.vue"
import NavControlSidebar from "./NavControlSidebar.vue";
export default {
  components: {
    NavSearch,
    NavMessages,
    NavNotifications,
    NavControlSidebar
  }
};
</script>
