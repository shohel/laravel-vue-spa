<template>
    
</template>

<script>
    export default {
        name: "page-title",
        props: ['title'],
        created(){
            document.title = this.title;
        },
        watch: {
            title(){
                document.title = this.title;
            },
        }
    }
</script>