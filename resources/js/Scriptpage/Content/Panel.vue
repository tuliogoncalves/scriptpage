<template>
	<scriptpage :contentHeader="contentHeader">
		<main-content :pageTitle="pageTitle">
			<!-- Toolbar -->
			<template #toolbar>
				<div class="col-sm text-right">
					<button-back :urlBack="urlBack" />
				</div>
			</template>

			<!-- Content -->
			<section>
				<slot></slot>
			</section>

			<!-- Footer -->
			<template #footer>
				<!-- Left button -->
				<div class="col-sm text-left"></div>

				<!-- Center button -->
				<div class="col-sm text-center">
					<bt
						v-if="urlButton"
						:urlButton="urlButton"
						:label="labelButton ? labelButton : 'OK'"
					/>
				</div>

				<!-- Right button -->
				<div class="col-sm text-right"></div>
			</template>
		</main-content>
	</scriptpage>
</template>

<script>
	import Scriptpage from "@/Scriptpage/Layout/Base.vue";
	import MainContent from "@/Scriptpage/Layout/Parts/MainContent.vue";
	import bt from "@/Components/Button.vue";
	import ButtonBack from "@/Components/ButtonBack.vue";

	export default {
		name: "Panel",

		components: {
			Scriptpage,
			MainContent,
			ButtonBack,
			bt,
		},

		props: {
			contentHeader: String,
			pageTitle: String,
			urlBack: String,
			urlButton: String,
			labelButton: String,
			urlAjax: String,
		},

		data() {
			return {
				result: Object,
			};
		},
	};
</script>
