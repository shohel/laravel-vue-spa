<template>

    <div class="pagination-wrap mt-5 text-center">

        <ul class="pagination" v-if="data.total">
            <li class="page-item" :class="data.current_page <= 1 ? 'disabled' :'' ">
                <a class="page-link" :href="'?page='+(data.current_page-1)" @click.stop.prevent="loadPage(data.current_page-1)">Previous</a>
            </li>


            <li class="page-item" :class="{active: (data.current_page === n) }" v-for="n in data.last_page">
                <a class="page-link" :href="'?page='+n" @click.stop.prevent="loadPage(n)">{{n}}</a>
            </li>

            <li class="page-item" :class="data.current_page === data.last_page ? 'disabled' :'' ">
                <a class="page-link" :href="'?page='+(data.current_page+1)" @click.stop.prevent="loadPage(data.current_page+1)">Next</a>
            </li>
        </ul>
    </div>

</template>


<script>
    export default {
        props : ['data'],
        methods : {
            loadPage(page){
                this.$router.replace({query: {page: page}});
            }
        }
    }
</script>