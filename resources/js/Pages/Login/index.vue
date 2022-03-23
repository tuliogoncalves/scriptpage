<template>
	<!-- Main Sidebar Container -->
	<aside class="main-sidebar">
		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul
					class="nav nav-pills nav-sidebar flex-column"
					data-widget="treeview"
					role="menu"
					data-accordion="true"
				/>
			</nav>
		</div>
	</aside>

	<div class="login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="https://scriptpage.com.br"
					><b>Scriptpage</b><sup>v1.3</sup></a
				>
			</div>

			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Sign in to start your session</p>

					<form @submit.prevent="onSubmit()">
						<!-- Email -->
						<div class="input-group mb-3">
							<input
								type="email"
								class="form-control"
								:class="{ 'is-invalid': errors.email }"
								placeholder="Email"
								v-model="form.email"
							/>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-envelope"></span>
								</div>
							</div>
							<span class="invalid-feedback">{{
								errors.email
							}}</span>
						</div>
						<div class="input-group mb-3">
							<input
								type="password"
								class="form-control"
								placeholder="Password"
								v-model="form.password"
							/>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="icheck-primary">
									<input
										type="checkbox"
										v-model="form.remember"
									/>
									<label for="remember"> Remember Me </label>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-4">
								<button
									type="submit"
									class="btn btn-default btn-block"
								>
									Sign In
								</button>
							</div>
							<!-- /.col -->
						</div>
					</form>

					<p class="mb-1">
						<a href="#">I forgot my password</a>
					</p>
					<p class="mb-0">
						<a href="#" class="text-center"
							>Register a new membership</a
						>
					</p>
				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
	</div>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import Sidebar from "@/Scriptpage/Layout/Parts/Sidebar.vue";

	export default {
		components: { Sidebar },
		setup() {
			$('[data-widget="pushmenu"]').PushMenu("toggle");
		},

		data() {
			return {
				form: Inertia.form({
					email: "",
					password: "",
					remember: false,
				}),
			};
		},

		props: {
			errors: Object,
		},

		methods: {
			onSubmit() {
				this.form
					.transform((data) => ({
						...data,
						remember: this.form.remember ? "On" : "",
					}))
					.post(route("login.do"), {
						onFinish: () => this.form.reset("password"),
					});
			},
		},
	};
</script>
