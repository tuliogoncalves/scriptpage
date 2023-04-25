<template>
	<index
		contentHeader="Client Manager"
		pageTitle="Clients"
		:urlButton="route('clients.create')"
		:paginator="paginator"
		:urlSearch="route('clients.index')"
	>
		<table class="table table-bordered table-hover mb-5">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Nome</th>
					<th scope="col">CPF</th>
					<th scope="col">Email</th>
					<th scope="col">Data de Nascimento</th>
					<th scope="col">Telefone</th>
					<th scope="col">CEP</th>
					<th scope="col">Estado</th>
					<th scope="col">Cidade</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="client in paginator.data">
					<th scope="row" class="text-center" style="width:30px">
						<Link
							class="text-decoration-none"
							:href="route('clients.show', client.id)"
							title="Edit Client"
						>
							<i class="icon edit"></i>
						</Link>
					</th>
					<td>{{ client.name }}</td>
					<td>{{ client.cpf }}</td>
					<td>{{ client.email }}</td>
					<td>{{ client.birth }}</td>
					<td>{{ client.tel_num }}</td>
					<td>{{ client.cep }}</td>
					<td>{{ client.state }}</td>
					<td>{{ client.city }}</td>
				</tr>
			</tbody>
		</table>
	</index>
</template>

<script>
	import Index from "@/Scriptpage/Content/Index.vue";
	import { Link } from "@inertiajs/inertia-vue3";

	export default {

		components: {
			Index,
			Link,
		},

		props: {
			paginator: Object,
		}
	};
</script>
