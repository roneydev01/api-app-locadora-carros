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
                        <table-component
                            :dados="marcas"
                            :titulos="['id', 'nome', 'imagem']"
                        >
                        </table-component>
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

                    <template v-slot:alertas>
                        <alert-component tipo="success" v-if="transacaoStatus == 'adicionado'" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" ></alert-component>
                        <alert-component tipo="danger" v-if="transacaoStatus == 'erro'" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar" ></alert-component>
                    </template>

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
    computed: {
        token() {
            //Recupera os dados do token, transforma em array separado por ';' e filtra pelo indice que tem 'token='
            let token = document.cookie.split(';').find(indice => {
                return indice.includes('token=')
            })
            //pega o segundo elemento do array e separa onde tiver '='
            token = token.split('=')[1]
            token = 'Bearer' +token

            return token
        }
    },
    data() {
        return {
            urlBase: 'http://localhost:8000/api/v1/marca',
            nomeMarca: '',
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: {},
            marcas: []
        };
    },
    methods: {
        carregarLista() {

            //Defindo os cabeçalhos da requisição
            let config = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            axios.get(this.urlBase, config)
                .then(response => {
                    this.marcas = response.data
                    //console.log(this.marcas)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
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
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            //Enviando a requisição
            axios
                .post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'Id do registro ' + response.data.id
                    }
                    //console.log(response);
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                    //console.log(errors.response);
                });
        }
    },
    mounted() {
        this.carregarLista()
    },
};
</script>
