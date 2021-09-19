<template>
    <div :class="estilo" role="alert">
        {{titulo}}
        <hr/>
        <!--Quando vem do response de errors-->
        <span v-if="detalhes.data.message">{{detalhes.data.message}}</span>
        <!--Quando vem do response de sucesso-->
        <span v-if="detalhes.data.id">{{'Id do registro ' + detalhes.data.id}}</span>
        <br/>
        <ul v-if="detalhes.data.errors">
            <li v-for="e, key in detalhes.data.errors" :key="key">{{ e[0] }}</li>
        </ul>
    </div>
</template>
<script>
export default ({
    props: ['tipo', 'titulo', 'detalhes'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
})
</script>
