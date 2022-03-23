<template>
	<Link class="btn btn-sm btn-default">
		<span>{{ label }}</span>
	</Link>
</template>

<script>
	import { Link } from "@inertiajs/inertia-vue3";

	export default {
		name: "ButtonSmall",

		components: {
			Link,
		},

		props: {
			label: String,
		},
	};
</script>
