<template>
	<scriptpage :contentHeader="contentHeader">
		<main-content :pageTitle="title">
			<!-- Toolbar -->
			<template #toolbar>
				<!-- Pause button -->
				<div class="col-sm text-right">
					<bt class="btn-sm" label="Pause" @click="onSubmit(route('task.pause', task_id))"/>
				</div>
			</template>

			<!-- Form fields -->
			<section>
				<slot></slot>
			</section>

			<!-- Footer -->
			<template #footer>
				<!-- Delete button -->
				<div class="col-sm text-left"></div>

				<!-- Follow button -->
				<div class="col-sm text-center">
					<bt
						label="Follow"
						title="go to the next task"
					/>
				</div>
				<div class="col-sm text-right"></div>
			</template>
		</main-content>
	</scriptpage>
</template>

<script>
	import { useForm } from "@inertiajs/inertia-vue3";
	import Scriptpage from "@/Scriptpage/Layout/Base.vue";
	import MainContent from "../Layout/Parts/MainContent.vue";
	import bt from "@/Components/Button.vue";

	export default {
		components: {
			Scriptpage,
			MainContent,
			bt
		},

		props: {
			contentHeader: String,
			title: String,
			errors: Object,
			data: Object,
			task_id: Number
		},

		data() {
			var data = this.data;
			return {
				form: useForm({
					id: this.task_id
				}),
			};
		},

		methods: {
			onSubmit(url) {
				var form = this.form;
				form.get(url);
			},
		},
	};
</script>
