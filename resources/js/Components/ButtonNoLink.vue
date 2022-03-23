<template>
	<!-- 
	## Danger!
	## Dont use component Link here 
	## Imcompatible with Form submit
	-->
	<button class="btn btn-default">
		<span>{{ label }}</span>
	</button>
</template>

<script>
	export default {
		name: "Button",

		props: {
			label: String
		}
	};
</script>
