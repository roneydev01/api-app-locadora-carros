<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key" class="text-text-uppercase">{{ t }}</th>
            </tr>
        </thead>
        <tbody>
            <!--Pega o obejto de dados do banco -->
            <tr v-for="obj in dados" :key="obj.id">
            <!--Verifica se os titulos passados pela props corresponde a chave do banco. Ex:id -->
                <td
                    v-if="titulos.includes(chave)"
                    v-for="valor, chave in obj" :key="chave"
                >
                    <span v-if="chave == 'imagem'">
                        <img :src="'/storage/'+valor" width="30" height="30">
                    </span>
                    <span v-else>
                        {{ valor }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    props: ['dados','titulos']
};
</script>
