<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key" class="text-text-uppercase">{{ t.titulo }}</th>
            </tr>
        </thead>
        <tbody>
            <!--Pega o obejto de dados do banco -->
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
            <!--Verifica se os titulos passados pela props corresponde a chave do banco. Ex:id -->
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'texto'">{{valor}}</span>
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                        <img :src="'/storage/'+valor" width="30" height="30">
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    props: ['dados','titulos'],
    computed: {
        dadosFiltrados() {
            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []
            //console.log(campos)
            //console.log(this.dados)
            this.dados.map((item, chave) => {
                //console.log(chave, item)
                let itemFiltrado = {}
                campos.forEach(campo => {
                    //console.log(campo)
                    itemFiltrado[campo] = item[campo]
                })
                //console.log(itemFiltrado)
                dadosFiltrados.push(itemFiltrado)
            })
            return dadosFiltrados
        }
    }
};
</script>
