<template>
	<Link class="btn btn-default" @click="onDelete()">
		<span>Delete</span>
	</Link>
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";
	import { Link } from "@inertiajs/inertia-vue3";

	export default {
		name: "ButtonDelete",

		components: {
			Link,
		},

		props: {
			urlDestroy: String
		},

		methods: {
			onDelete() {
				Swal.fire({
					title: "Are you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, delete it!",
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {
						Inertia.delete(this.urlDestroy);
					}
				});
			},
		},
	};
</script>
