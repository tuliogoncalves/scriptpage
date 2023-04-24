<template>
	<index
		contentHeader="Cliente Manager"
		pageTitle="Clientes"
		:urlButton="route('clientes.create')"
		:paginator="paginator"
		:urlSearch="route('clientes.index')"
	>
		<table class="table table-bordered table-hover mb-5">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Nome</th>
					<th scope="col">Email</th>
					<th scope="col">CPF</th>
					<th scope="col">Telefone</th>
					<th scope="col">Nascimento</th>
					<th scope="col">Endereço</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="cliente in paginator.data">
					<th scope="row" class="text-center" style="width:30px">
						<Link
							class="text-decoration-none"
							:href="route('clientes.show', cliente.id)"
							title="Edit Cliente"
						>
							<i class="icon edit"></i>
						</Link>
					</th>
					<td>{{ cliente.name }}</td>
					<td>{{ cliente.email }}</td>
					<td>{{ cliente.cpf }}</td>
					<td>{{ cliente.telephone }}</td>
					<td>{{ cliente.data_nascimento }}</td>
					<td>{{ cliente.estado }}</td>
					<td>{{ cliente.cidade }}</td>
					<td>{{ cliente.endereco }}</td>
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
