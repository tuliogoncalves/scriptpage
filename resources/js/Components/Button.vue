<template>
	<Link :href="urlButton" class="btn btn-default">
		<span>{{ label }}</span>
	</Link>
</template>

<script>
	import { Link } from "@inertiajs/inertia-vue3";
	
	export default {
		name: "Button",

		components: {
			Link,
		},

		props: {
			urlButton: String,
			label: String,
		},
	};
</script>
