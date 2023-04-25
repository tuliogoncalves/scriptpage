<template>
	<index
		contentHeader="Cadastro de fornecedores"
		pageTitle="Fornecedores"
		:urlButton="route('fornecedores.create')"
		:paginator="paginator"
		:urlSearch="route('fornecedores.index')"
	>
		<table class="table table-bordered table-hover mb-5">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Nome</th>
					<th scope="col">Email</th>
					<th scope="col">cnpj</th>
					<th scope="col">endereco</th>
					<th scope="col">telefone</th>
					<th scope="col">cidade</th>
				
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in paginator.data">
					<th scope="row" class="text-center" style="width:30px">
						<Link
							class="text-decoration-none"
							:href="route('fornecedores.show', fornecedores.id)"
							title="Edit User"
						>
							<i class="icon edit"></i>
						</Link>
					</th>
					<td>{{ fornecedores.name }}</td>
					<td>{{ fornecedores.email }}</td>
					<td>{{ fornecedores.cnpj }}</td>
					<td>{{ fornecedores.endereco }}</td>
					<td>{{ fornecedores.telefone }}</td>
					<td>{{ fornecedores.cidade}}</td>
				</tr>
			</tbody>
		</table>
	</index>
</template>

<script>
	import Index from "@/Scriptpage/Content/Index.vue";
	import { Link } from "@inertiajs/inertia-vue3";

	export default {
		name: "UserIndex",

		components: {
			Index,
			Link,
		},

		props: {
			paginator: Object,
		}
	};
</script>
