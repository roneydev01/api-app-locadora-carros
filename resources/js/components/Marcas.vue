<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card de busca-->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do registro."
                                >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputId"
                                        aria-describedby="idHelp"
                                        placeholder="ID"
                                    />
                                </input-container-component>
                            </div>
                            <div class=" col mb-3">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome"
                                    id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca."
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputNome"
                                        aria-describedby="nomeHelp"
                                        placeholder="Nome da marca"
                                    />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                        >
                            Pesquisar
                        </button>
                    </template>
                </card-component>
                <!--Fim do card de busca-->

                <!--Inicio do card de listagem de marcas-->
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                            data-toggle="modal"
                            data-target="#idModal"
                        >
                            Adicionar
                        </button>
                    </template>
                </card-component>
                <!--Fim do card de listagem de marcas-->
                <modal-component id="idModal" titulo="Adicionar Marca">
                    <template v-slot:conteudo>
                        <div class="form-group">
                            <input-container-component
                                id="novoNome"
                                titulo="Nome da Marca"
                                id-help="novonomeHelp"
                                texto-ajuda="Informe o nome da marca."
                            >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="novoNome"
                                    aria-describedby="novonomeHelp"
                                    placeholder="Nome da marca"
                                    v-model="nomeMarca"
                                />
                            </input-container-component>
                            <input-container-component
                                id="novaImagem"
                                titulo="Imagem"
                                id-help="novaImagemHelp"
                                texto-ajuda="Seleciona uma imagem."
                            >
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="novaImagem"
                                    aria-describedby="novaImagemHelp"
                                    placeholder="Seleciona uma imagem."
                                    @change="carregarImagem($event)"
                                />
                            </input-container-component>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Fechar
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="salvar()"
                        >
                            Salvar
                        </button>
                    </template>
                </modal-component>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            urlBase: 'http://localhost:800/api/v1/marca',
            nomeMarca: "",
            arquivoImagem: []
        };
    },
    methods: {
        carregarImagem(e) {
            this.arquivoImagem = e.target.files;
        },
        salvar() {
            console.log(this.nomeMarca, this.arquivoImagem[0]);
            //Criado o formulário
            let formData = new FormData();
            formData.append("nome", this.nomeMarca);
            formData.append("imagem", this.arquivoImagem[0]);

            //Defindo os cabeçalhos da requisição
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'aplication/json'
                }
            };

            //Enviando a requisição
            axios
                .post(this.urlBase, formData, config)
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    }
};
</script>
