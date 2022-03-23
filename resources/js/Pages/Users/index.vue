<template>
	<index
		contentHeader="User Manager"
		pageTitle="Users"
		:urlButton="route('users.create')"
		:paginator="paginator"
		:urlSearch="route('users.index')"
	>
		<table class="table table-bordered table-hover mb-5">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in paginator.data">
					<th scope="row" class="text-center" style="width:30px">
						<Link
							class="text-decoration-none"
							:href="route('users.show', user.id)"
							title="Edit User"
						>
							<i class="icon edit"></i>
						</Link>
					</th>
					<td>{{ user.name }}</td>
					<td>{{ user.email }}</td>
				</tr>
			</tbody>
		</table>
	</index>
</template>

<script>
	import Index from "@/Scriptpage/Content/Index.vue";
	import { Link } from "@inertiajs/inertia-vue3";

	export default {
		name: "UserIndex",

		components: {
			Index,
			Link,
		},

		props: {
			paginator: Object,
		}
	};
</script>
