<template>
	<div class="sidebar-mini">
		<div class="wrapper">
			<span v-if="onAlert($page.props.flash.success)"/>
			
			<navbar />

			<sidebar />

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<content-header :pageTitle="contentHeader" />

				<!-- Main content -->
				<div id="main-content" class="content">
					<div class="container-fluid">
						<div class="row">
							<slot></slot>
						</div>
					</div>
				</div>
				<!-- /.Main content -->
			</div>
			<!-- /.content-wrapper -->

			<!-- Control Sidebar -->
			<control-sidebar />

			<!-- Main Footer -->
			<app-footer />
		</div>
		<!-- ./wrapper -->
	</div>
</template>

<script>
	import ContentHeader from "./Parts/ContentHeader.vue";
	import Navbar from "./Parts/Navbar.vue";
	import Sidebar from "./Parts/Sidebar.vue";
	import ControlSidebar from "./Parts/ControlSidebar.vue";
	import AppFooter from "./Parts/Footer.vue";

	export default {
		components: {
			Navbar,
			Sidebar,
			ContentHeader,
			ControlSidebar,
			AppFooter,
		},

		props: {
			contentHeader: String,
		},

		methods: {
			onAlert(msg) {
				if (msg) {
					toastr.options = {
						closeButton: false,
						debug: false,
						newestOnTop: false,
						progressBar: false,
						positionClass: "toast-top-center",
						preventDuplicates: false,
						onclick: null,
						showDuration: "300",
						hideDuration: "1000",
						timeOut: "2200",
						extendedTimeOut: "1000",
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut",
					};
					toastr.success(msg);
				}
			},
		},
	};
</script>
