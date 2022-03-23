<template>
	<Link
		:href="(urlBack) ? urlBack : $page.props.flash.url"
		class="btn btn-sm btn-default"
	>
		<span>Back</span>
	</Link>
</template>

<script>
	import { Link } from "@inertiajs/inertia-vue3";

	export default {
		name: "ButtonBack",

		components: {
			Link,
		},

		props: {
			urlBack: String,
		},
	};
</script>
