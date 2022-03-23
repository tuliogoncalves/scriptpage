<template>
	<!-- Main Content -->
	<div class="container-xl px-4 mt-4">
		<div class="card shadow mb-4">
			<!-- Page Header -->
			<div class="card-header">
				<h6 class="font-weight-bold text-primary">
					{{ pageTitle }}
				</h6>

				<!-- Toolbar -->
				<div class="row bg-light justify-content-between py-2">
					<slot name="toolbar"></slot>
				</div>
			</div>

			<!-- Page Content -->
			<div class="card-body">
				<div class="card-body border mb-1">
					<slot></slot>
				</div>
			</div>

			<!-- Footer -->
			<div class="card-footer justify-content-between">
				<div class="row">
					<slot name="footer"></slot>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "MainContent",

		props: {
			pageTitle: String,
		},
	};
</script>
