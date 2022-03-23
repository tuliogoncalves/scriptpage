<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item" v-if="data.prev_page_url">
                <Link 
                    class="page-link"
                    :href="data.prev_page_url" 
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </Link>
            </li>

            <li v-for="link in cleanLinks"
                :class="{'active': link.active}"
                class="page-item"
                v-if="cleanLinks.length > 1">
                <Link class="page-link" :href="link.url">{{ link.label }}</Link>
            </li>

            <li class="page-item" v-if="data.next_page_url">
                <Link class="page-link" 
                    :href="data.next_page_url"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    export default {
        components: { Link },
        props : {
            data: Object,
        },
        computed: {
            cleanLinks() {
                const cleanLinks = [...this.data.links];
                cleanLinks.shift();
                cleanLinks.pop();
                return cleanLinks;
            }
        }
    }
</script>
