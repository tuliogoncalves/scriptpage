<template>
	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul
			class="nav nav-pills nav-sidebar flex-column"
			data-widget="treeview"
			role="menu"
			data-accordion="true">
			<li
				class="nav-item"
				:class="{
					'menu-is-opening menu-open': route().current('users.*'),
				}">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-tachometer-alt"></i>
					<p>
						<i class="right fas fa-angle-left"></i> Setup
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a
							:href="route('users.index')"
							class="nav-link"
							:class="{ active: route().current('users.*') }">
							<i class="far fa-circle nav-icon"></i>
							<p>Users</p>
						</a>
					</li>
					<li v-if="can('admin')" class="nav-item">
						<a href="#" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Groups</p>
						</a>
					</li>
				</ul>
			</li>
			<li
				class="nav-item"
				:class="{
					'menu-is-opening menu-open': route().current('clients.*'),
				}">
				<a href="#" class="nav-link">
					<i class="fas fa-handshake p-1"></i>
					<p>
						<i class="right fas fa-angle-left"></i> Cliente
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a
							:href="route('clients.index')"
							class="nav-link"
							:class="{ active: route().current('clients.*') }">
							<i class="far fa-circle nav-icon"></i>
							<p>Clientes</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a :href="route('logout')" class="nav-link">
					<i class="nav-icon fas fa-th"></i>
					<p>Logout</p>
				</a>
			</li>
		</ul>
	</nav>
</template>
<script>
export default {
	methods: {
		can(name) {
			const user = this.$page.props.flash.user;
			const result = user.roles.find((role) => role.name === name);
			return result != null;
		},
	},
};
</script>
