<template>
	<scriptpage :contentHeader="contentHeader">
		<main-content :pageTitle="pageTitle">
			<!-- Toolbar -->
			<template #toolbar>
				<!-- Search Box -->
				<div class="col-sm-4">
					<searchbox v-if="urlSearch" :urlSearch="urlSearch" />
				</div>

				<!-- New button -->
				<div class="col-sm-2 text-center py-1">
					<button-small
						v-if="urlButton"
						:href="urlButton"
						:label="labelButton ? labelButton : 'New'"
					/>
				</div>

				<!-- Back button -->
				<div class="col-sm-2 text-right py-1">
					<button-back v-if="urlBack" :urlBack="urlBack" />
				</div>
			</template>

			<!-- Paginator -->
			<div class="card-body border mb-1">
				<slot></slot>
				<pagination v-if="paginator" :data="paginator" />
			</div>
		</main-content>
	</scriptpage>
</template>

<script>
	import Scriptpage from "@/Scriptpage/Layout/Base.vue";
	import MainContent from "@/Scriptpage/Layout/Parts/MainContent.vue";
	import ButtonBack from "@/Components/ButtonBack.vue";
	import ButtonSmall from "@/Components/ButtonSmall.vue"
	import Searchbox from "@/Components/SearchBox.vue";
	import Pagination from "@/Components/Pagination.vue";

	export default {
		name: "Index",

		components: {
			Scriptpage,
			MainContent,
			ButtonBack,
			ButtonSmall,
			Searchbox,
			Pagination,
		},

		props: {
			contentHeader: String,
			pageTitle: String,
			paginator: Object,
			urlBack: String,
			urlButton: String,
			labelButton: String,
			urlSearch: String
		},
	};
</script>
