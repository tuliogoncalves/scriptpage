<template>
	<!-- Search box -->
	<section>
		<div class="d-none d-sm-inline-block form-inline">
			<div class="input-group input-group-joined input-group-solid">
				<input
					type="search"
					v-model="search"
					class="form-control"
					placeholder="Search for..."
					:onsearch="onSearch"
				/>
				<div class="input-group-append">
					<a class="btn btn-default" @click="onSearch">
						<i class="fas fa-search fa-sm"></i>
					</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Search box -->
</template>

<script>
	import { Inertia } from "@inertiajs/inertia";

	export default {
		name: "SearchBox",

		props: {
			urlSearch: String,
		},

		data() {
			let urlParams = new URLSearchParams(window.location.search);
			return {
				search: urlParams.get("search"),
			};
		},

		methods: {
			onSearch() {
				Inertia.get(
					this.urlSearch,
					{ search: this.search },
					{ preserveState: true }
				);
			},
		},
	};
</script>
