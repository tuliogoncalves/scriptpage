<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link" :href="route('home')" aria-label="Previous">
      <img 
        :src="'/dist/img/AdminLTELogo.png'"
        alt="Scriptpage logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">Scriptpage v1.333</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <sidebar-user-panel/> -->
        
        <div class="pb-3 mb-3 d-flex"/>

        <!-- SidebarSearch Form -->
        <sidebar-search/>

        <!-- Sidebar Menu -->
        <sidebar-menu/>
    </div>
  </aside>
</template>

<script>
import SidebarUserPanel from "./SidebarUserPanel.vue"
import SidebarSearch from "./SidebarSearch.vue"
import SidebarMenu from "./Menu.vue"

export default {
    components: {
        SidebarUserPanel,
        SidebarSearch,
        SidebarMenu
    }
};
</script>
