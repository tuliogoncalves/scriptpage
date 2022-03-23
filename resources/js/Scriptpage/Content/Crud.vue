<template>
	<scriptpage :contentHeader="contentHeader">
		<main-content :pageTitle="form.id ? updateTitle : createTitle">
			<!-- Toolbar -->
			<template #toolbar>
				<div class="col-sm text-right">
					<button-back :urlBack="urlBack" />
				</div>
			</template>

			<!-- Form fields -->
			<section>
				<slot></slot>
			</section>

			<!-- Footer -->
			<template #footer>
				<!-- Delete button -->
				<div class="col-sm text-left">
					<button-delete
						v-if="form.id"
						label="Delete"
						:urlDestroy="urlDestroy"
					/>
				</div>

				<!-- Create / Update -->
				<div class="col-sm text-center">
					<!-- Update button -->
					<bt
						v-if="urlUpdate && form.id"
						class="btn btn-default"
						label="Update"
						@click="onSubmit"
						title="Update current data"
					/>

					<!-- Create button -->
					<bt
						v-if="urlStore && !form.id"
						label="Create"
						@click="onSubmit"
						title="Add new data"
					/>
				</div>
				<div class="col-sm text-right"></div>
			</template>
		</main-content>
	</scriptpage>
</template>

<script>
	import Scriptpage from "@/Scriptpage/Layout/Base.vue";
	import MainContent from "@/Scriptpage/Layout/Parts/MainContent.vue";
	import bt from "@/Components/ButtonNoLink.vue";
	import ButtonBack from "@/Components/ButtonBack.vue";
	import ButtonDelete from "@/Components/ButtonDelete.vue";

	export default {
		components: {
			Scriptpage,
			MainContent,
			bt,
			ButtonBack,
			ButtonDelete,
		},

		props: {
			contentHeader: String,
			createTitle: String,
			updateTitle: String,
			form: Object,
			urlBack: String,
			urlUpdate: String,
			urlStore: String,
			urlDestroy: String,
			errors: Object,
		},

		methods: {
			onSubmit() {
				var form = this.form;
				if (form.id) {
					form.put(this.urlUpdate);
				} else {
					form.post(this.urlStore);
				}
			},
		},
	};
</script>
